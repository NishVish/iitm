<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\LeadModel;
use App\Models\UpdationModel;
use App\Models\SourceModel;
use App\Models\MatchingSessionModel;

class CrossValidationModel extends Model
{
    protected $db;
    protected $companyModel;
    protected $contactModel;
    protected $sourceModel;
    protected $updationModel;
    protected $leadModel;
    protected $matchingSessionModel;

    public function __construct()
    {
        parent::__construct(); // Required for CodeIgniter Model

        $this->db                   = \Config\Database::connect();
        $this->companyModel         = new CompanyModel();
        $this->contactModel         = new ContactModel();
        $this->sourceModel          = new SourceModel();
        $this->updationModel        = new UpdationModel();
        $this->leadModel            = new LeadModel();
        $this->matchingSessionModel = new MatchingSessionModel();
    }

    // -------------------------------------------------------------------------
    // MAIN METHOD
    // -------------------------------------------------------------------------

    /**
     * Cross-validate an incoming company + contact payload against the DB.
     *
     * @param  array $input  Keys: company_name, phone, gst_number, city, state,
     *                       country, pincode, address, category,
     *                       contacts => [ [ name, designation, emails=>[], mobiles=>[] ], … ]
     * @return array {
     *   status          : 'new'|'existing',
     *   matched_company : array|null,
     *   company_match   : {
     *       overall_percent : float,
     *       fields          : { field => { matched: bool, score: float, weight: int } }
     *   },
     *   contact_matches : [ {
     *       input_contact   : array,
     *       status          : 'new'|'existing',
     *       matched_contact : array|null,
     *       match_percent   : float,
     *       field_detail    : array
     *   } ]
     * }
     */
    public function crossValidate(array $input): array
    {
        // ── 1. Normalise input ────────────────────────────────────────────────
        $inCompany  = $this->normaliseCompany($input);
        $inContacts = $input['contacts'] ?? [];

        // ── 2. Fetch candidate companies ──────────────────────────────────────
        $candidates = $this->fetchCandidateCompanies($inCompany);

        // ── 3. Score every candidate, keep best ───────────────────────────────
        $bestScore   = -1;
        $bestCompany = null;
        $bestDetail  = [];

        foreach ($candidates as $candidate) {
            $result = $this->scoreCompany($inCompany, $candidate);
            if ($result['overall_percent'] > $bestScore) {
                $bestScore   = $result['overall_percent'];
                $bestCompany = $candidate;
                $bestDetail  = $result;
            }
        }

        // ── 4. Decide new / existing (threshold: 40%) ─────────────────────────
        $threshold     = 40.0;
        $companyStatus = ($bestScore >= $threshold) ? 'existing' : 'new';

        // ── 5. Match contacts ─────────────────────────────────────────────────
        $contactMatches = [];
        foreach ($inContacts as $inContact) {
            $contactMatches[] = $this->matchContact(
                $inContact,
                $bestCompany['company_id'] ?? null
            );
        }

        // ── 6. Mark cross_validation flag in DB if existing ───────────────────
        if ($companyStatus === 'existing' && $bestCompany) {
            $this->db->table('company_data')
                ->where('company_id', $bestCompany['company_id'])
                ->update(['cross_validation' => 1]);
        }

        return [
            'status'          => $companyStatus,
            'matched_company' => $bestCompany,
            'company_match'   => $bestDetail,
            'contact_matches' => $contactMatches,
        ];
    }

    // -------------------------------------------------------------------------
    // COMPANY HELPERS
    // -------------------------------------------------------------------------

    private function fetchCandidateCompanies(array $in): array
    {
        $orConditions = [];

        if (!empty($in['gst_number'])) {
            $orConditions[] = "gst_number = " . $this->db->escape($in['gst_number']);
        }
        if (!empty($in['phone'])) {
            $orConditions[] = "phone = " . $this->db->escape($in['phone']);
        }
        if (!empty($in['company_name'])) {
            $word = strtok($in['company_name'], ' ');
            if (strlen($word) >= 4) {
                $orConditions[] = "company_name LIKE " . $this->db->escape('%' . $word . '%');
            }
        }

        if (empty($orConditions)) {
            return [];
        }

        $query = $this->db->table('company_data')
            ->where('(' . implode(' OR ', $orConditions) . ')')
            ->get();

        return $query ? $query->getResultArray() : [];
    }

    private function scoreCompany(array $in, array $existing): array
    {
        $fields = [
            'company_name' => ['weight' => 30, 'fn' => 'fuzzy'],
            'gst_number'   => ['weight' => 25, 'fn' => 'exact'],
            'phone'        => ['weight' => 20, 'fn' => 'exact'],
            'city'         => ['weight' => 10, 'fn' => 'exact_ci'],
            'state'        => ['weight' =>  5, 'fn' => 'exact_ci'],
            'country'      => ['weight' =>  5, 'fn' => 'exact_ci'],
            'pincode'      => ['weight' =>  5, 'fn' => 'exact'],
        ];

        $totalWeight  = 0;
        $earnedScore  = 0;
        $fieldResults = [];

        foreach ($fields as $field => $cfg) {
            $inVal  = trim($in[$field]       ?? '');
            $dbVal  = trim($existing[$field] ?? '');
            $weight = $cfg['weight'];

            if ($inVal === '' || $dbVal === '') {
                $fieldResults[$field] = [
                    'matched' => null,
                    'score'   => null,
                    'weight'  => $weight,
                    'note'    => 'skipped (empty)',
                ];
                continue;
            }

            $score = match ($cfg['fn']) {
                'exact'    => $inVal === $dbVal ? 1.0 : 0.0,
                'exact_ci' => strtolower($inVal) === strtolower($dbVal) ? 1.0 : 0.0,
                'fuzzy'    => $this->similarityScore($inVal, $dbVal),
                default    => 0.0,
            };

            $earnedScore += $score * $weight;
            $totalWeight += $weight;

            $fieldResults[$field] = [
                'matched' => $score >= 0.7,
                'score'   => round($score * 100, 1),
                'weight'  => $weight,
            ];
        }

        $overallPercent = $totalWeight > 0
            ? round(($earnedScore / $totalWeight) * 100, 2)
            : 0.0;

        return [
            'overall_percent' => $overallPercent,
            'fields'          => $fieldResults,
        ];
    }

    // -------------------------------------------------------------------------
    // CONTACT HELPERS
    // -------------------------------------------------------------------------

    private function matchContact(array $inContact, ?string $companyId): array
    {
        $base = [
            'input_contact'   => $inContact,
            'status'          => 'new',
            'matched_contact' => null,
            'match_percent'   => 0.0,
            'field_detail'    => [],
        ];

        if (!$companyId) {
            return $base;
        }

        $existingContacts = $this->loadContactsForCompany($companyId);

        $bestScore   = -1;
        $bestContact = null;
        $bestDetail  = [];

        foreach ($existingContacts as $ec) {
            [$score, $detail] = $this->scoreContact($inContact, $ec);
            if ($score > $bestScore) {
                $bestScore   = $score;
                $bestContact = $ec;
                $bestDetail  = $detail;
            }
        }

        if ($bestScore >= 40.0) {
            $base['status']          = 'existing';
            $base['matched_contact'] = $bestContact;
            $base['match_percent']   = $bestScore;
            $base['field_detail']    = $bestDetail;
        }

        return $base;
    }

    private function loadContactsForCompany(string $companyId): array
    {
        $contacts = $this->db->table('contact')
            ->where('company_id', $companyId)
            ->get()
            ->getResultArray();

        foreach ($contacts as &$c) {
            $c['emails'] = $this->db->table('contact_email')
                ->where('contact_id', $c['contact_id'])
                ->get()
                ->getResultArray();

            $c['mobiles'] = $this->db->table('contact_mobile')
                ->where('contact_id', $c['contact_id'])
                ->get()
                ->getResultArray();
        }

        return $contacts;
    }

    private function scoreContact(array $in, array $existing): array
    {
        $detail      = [];
        $earnedScore = 0;
        $totalWeight = 0;

        // name
        $inName = trim($in['name']       ?? '');
        $dbName = trim($existing['name'] ?? '');
        if ($inName !== '' && $dbName !== '') {
            $score        = $this->similarityScore($inName, $dbName);
            $earnedScore += $score * 40;
            $totalWeight += 40;
            $detail['name'] = ['matched' => $score >= 0.7, 'score' => round($score * 100, 1), 'weight' => 40];
        }

        // designation
        $inDesig = strtolower(trim($in['designation']       ?? ''));
        $dbDesig = strtolower(trim($existing['designation'] ?? ''));
        if ($inDesig !== '' && $dbDesig !== '') {
            $score        = $this->similarityScore($inDesig, $dbDesig);
            $earnedScore += $score * 20;
            $totalWeight += 20;
            $detail['designation'] = ['matched' => $score >= 0.7, 'score' => round($score * 100, 1), 'weight' => 20];
        }

        // email
        $inEmails = array_column($in['emails']       ?? [], 'email');
        $dbEmails = array_column($existing['emails'] ?? [], 'email');
        if (!empty($inEmails) && !empty($dbEmails)) {
            $matched      = !empty(array_intersect(
                array_map('strtolower', $inEmails),
                array_map('strtolower', $dbEmails)
            ));
            $score        = $matched ? 1.0 : 0.0;
            $earnedScore += $score * 25;
            $totalWeight += 25;
            $detail['email'] = ['matched' => $matched, 'score' => $matched ? 100 : 0, 'weight' => 25];
        }

        // mobile
        $inMobiles = array_column($in['mobiles']       ?? [], 'mobile');
        $dbMobiles = array_column($existing['mobiles'] ?? [], 'mobile');
        if (!empty($inMobiles) && !empty($dbMobiles)) {
            $normIn  = array_map(fn($m) => preg_replace('/\D/', '', $m), $inMobiles);
            $normDb  = array_map(fn($m) => preg_replace('/\D/', '', $m), $dbMobiles);
            $matched = !empty(array_intersect($normIn, $normDb));
            $score   = $matched ? 1.0 : 0.0;
            $earnedScore += $score * 15;
            $totalWeight += 15;
            $detail['mobile'] = ['matched' => $matched, 'score' => $matched ? 100 : 0, 'weight' => 15];
        }

        $overallPercent = $totalWeight > 0
            ? round(($earnedScore / $totalWeight) * 100, 2)
            : 0.0;

        return [$overallPercent, $detail];
    }

    // -------------------------------------------------------------------------
    // UTILITY
    // -------------------------------------------------------------------------

    private function normaliseCompany(array $input): array
    {
        return [
            'company_name' => $input['company_name'] ?? '',
            'phone'        => preg_replace('/\D/', '', $input['phone'] ?? ''),
            'gst_number'   => strtoupper(trim($input['gst_number'] ?? '')),
            'city'         => $input['city']     ?? '',
            'state'        => $input['state']    ?? '',
            'country'      => $input['country']  ?? '',
            'pincode'      => $input['pincode']  ?? '',
            'address'      => $input['address']  ?? '',
            'category'     => $input['category'] ?? '',
        ];
    }

    private function similarityScore(string $a, string $b): float
    {
        if ($a === $b) return 1.0;

        $a = strtolower($a);
        $b = strtolower($b);

        similar_text($a, $b, $pct);
        $simScore = $pct / 100;

        $maxLen   = max(strlen($a), strlen($b));
        $levScore = $maxLen > 0 ? 1 - (levenshtein($a, $b) / $maxLen) : 0;

        return round(($simScore * 0.6) + ($levScore * 0.4), 4);
    }



    public function index()
    {

    }

    public function companyValidation($data)
{
    $companyName = trim($data['company_name'] ?? '');
    $personName  = trim($data['contact1_name'] ?? '');
    $mobile      = trim($data['contact1_mobile1'] ?? '');
    $email       = trim($data['contact1_email1'] ?? '');
    $newAddress  = trim($data['address'] ?? '');

    if (empty($mobile)) {
        return [false, $companyName, $personName];
    }

    $this->db->transStart();

    // 1️⃣ Find mobile
    $mobileRecord = $this->contactMobileModel
                         ->where('mobile', $mobile)
                         ->first();

    if (!$mobileRecord) {
        return [false, $companyName, $personName];
    }

    $contactId = $mobileRecord['contact_id'];

    // 2️⃣ Get contact
    $contact = $this->contactModel->find($contactId);

    if (!$contact) {
        return [false, $companyName, $personName];
    }

    $companyId = $contact['company_id'];

    // 3️⃣ PERSON NAME CHECK
    if (!empty($personName) &&
        strtolower(trim($contact['name'])) !== strtolower($personName)) {

        // Create new contact
        $newContactId = $this->contactModel->insert([
            'company_id' => $companyId,
            'name'       => $personName,
            'priority'   => 1
        ], true);

        // Move mobile
        $this->contactMobileModel
             ->where('id', $mobileRecord['id'])
             ->set(['contact_id' => $newContactId])
             ->update();

        // Move email if exists
        if (!empty($email)) {
            $emailRecord = $this->contactEmailModel
                                ->where('contact_id', $contactId)
                                ->where('email', $email)
                                ->first();

            if ($emailRecord) {
                $this->contactEmailModel
                     ->where('id', $emailRecord['id'])
                     ->set(['contact_id' => $newContactId])
                     ->update();
            }
        }

        $contactId = $newContactId;
    }

    // 4️⃣ ADDRESS CHECK
    if (!empty($newAddress)) {

        $company = $this->companyModel->find($companyId);

        if (empty($company['address']) ||
            trim($company['address']) !== $newAddress) {

            $this->companyModel->update($companyId, [
                'address' => $newAddress
            ]);
        }
    }

    // 5️⃣ EMAIL CHECK
    if (!empty($email)) {

        $emailExists = $this->contactEmailModel
                            ->where('contact_id', $contactId)
                            ->where('email', $email)
                            ->first();

        if (!$emailExists) {
            $this->contactEmailModel->insert([
                'contact_id' => $contactId,
                'email'      => $email
            ]);
        }
    }

    $this->db->transComplete();

    return [true, $companyName, $personName];
}
}