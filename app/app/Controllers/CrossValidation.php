<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\LeadModel;
use App\Models\UpdationModel;
use App\Models\SourceModel;
use App\Models\ContactEmailModel;
use App\Models\ContactMobileModel;
use App\Models\MatchingSessionModel;

class CrossValidation extends Controller
{
    protected $companyModel;
    protected $contactModel;
    protected $sourceModel;
    protected $updationModel;
    protected $leadModel;
    protected $db;

    public function __construct()
    {
            // Initialize models
                $this->db = \Config\Database::connect();

            $this->companyModel   = new CompanyModel();
            $this->contactModel   = new ContactModel();
            $this->sourceModel    = new SourceModel();
            $this->updationModel  = new UpdationModel();
                        $this->leadModel  = new LeadModel();

            $this->matchingSessionModel  = new MatchingSessionModel();
    }
    public function index()
    {
        $db = \Config\Database::connect();

    $companyMatches = $db->table('matching_session as ms')
        ->select('ms.*, 
                c1.company_id as original_company_id,
                c1.database_name as original_database_name,
                c1.outbound as original_outbound,
                c1.company_name as original_company_name,
                c1.category as original_category,
                c1.address as original_address,
                c1.city as original_city,
                c1.pincode as original_pincode,
                c1.state as original_state,
                c1.country as original_country,
                c1.phone as original_phone,
                c1.gst_number as original_gst_number,
                c1.sales_person as original_sales_person,
                c1.active_inactive as original_active_inactive,
                c1.created_at as original_created_at,
                c1.updated_at as original_updated_at,
                c1.last_confirmed_at as original_last_confirmed_at,
                c1.session as original_session,
                c1.cross_validation as orignal_cross_validation,
                
                c2.company_id as matched_company_id,
                c2.database_name as matched_database_name,
                c2.outbound as matched_outbound,
                c2.company_name as matched_company_name,
                c2.category as matched_category,
                c2.address as matched_address,
                c2.city as matched_city,
                c2.pincode as matched_pincode,
                c2.state as matched_state,
                c2.country as matched_country,
                c2.phone as matched_phone,
                c2.gst_number as matched_gst_number,
                c2.sales_person as matched_sales_person,
                c2.active_inactive as matched_active_inactive,
                c2.created_at as matched_created_at,
                c2.updated_at as matched_updated_at,
                c2.last_confirmed_at as matched_last_confirmed_at,
                c2.cross_validation as matched_cross_validation,
                c2.session as matched_session')
        ->join('company_data c1', 'ms.company_id = c1.company_id')
        ->join('company_data c2', 'ms.matching_company_id = c2.company_id')
        ->get()
        ->getResultArray();



        // ---------------- Contact Matches ----------------
        $contactMatches = $db->table('matching_contact_session as mcs')
            ->select('mcs.*, 
                    c1.name as original_name, c1.designation as original_designation,
                    c2.name as matched_name, c2.designation as matched_designation')
            ->join('contact c1', 'mcs.contact_id = c1.contact_id')
            ->join('contact c2', 'mcs.matching_contact_id = c2.contact_id')
            ->get()->getResultArray();

    // Fetch emails (take first email per contact)
    $emailRows = $db->table('contact_email')->select('contact_id, email')->orderBy('email_id', 'ASC')->get()->getResultArray();
    $emailMap = [];
    foreach ($emailRows as $row) {
        if (!isset($emailMap[$row['contact_id']])) {
            $emailMap[$row['contact_id']] = $row['email']; // first email for this contact
        }
    }

    // Fetch mobiles (take first mobile per contact)
    $mobileRows = $db->table('contact_mobile')->select('contact_id, mobile')->orderBy('mobile_id', 'ASC')->get()->getResultArray();
    $mobileMap = [];
    foreach ($mobileRows as $row) {
        if (!isset($mobileMap[$row['contact_id']])) {
            $mobileMap[$row['contact_id']] = $row['mobile']; // first mobile for this contact
        }
    }


        // ---------------- Attach emails/mobiles to contact matches ----------------
        foreach ($contactMatches as &$match) {
            $match['original_email'] = $emailMap[$match['contact_id']] ?? 'N/A';
            $match['original_mobile'] = $mobileMap[$match['contact_id']] ?? 'N/A';
            $match['matched_email'] = $emailMap[$match['matching_contact_id']] ?? 'N/A';
            $match['matched_mobile'] = $mobileMap[$match['matching_contact_id']] ?? 'N/A';
        }

        return view('crossvalidation/index', [
            'company_matches' => $companyMatches,
            'contact_matches' => $contactMatches
        ]);
    }


    public function clearMatches(){
        $db = \Config\Database::connect();

            // -------------------- 1. Company Matching --------------------
            $db->table('matching_session')->truncate();
        return $this->index(); // show the index page with all results
    }
    public function clearMatchesContact(){
        $db = \Config\Database::connect();

            // -------------------- 1. Company Matching --------------------
            $db->table('matching_contact_session')->truncate();
        return $this->index(); // show the index page with all results
    }
    /**
     * Run full cross-validation for companies + contacts
     */



// i want to optimize this on 4000 entires it crases while i have 100000 entires to insert

    public function companyCrossValidation()
    {
        $db = \Config\Database::connect();

        // -------------------- 1. Company Matching --------------------
        $db->table('matching_session')->truncate();
        $companies = $this->companyModel->findAll();
        $count = count($companies);
$batch = [];
$batchSize = 1000;

$companiesByCity = [];
foreach ($companies as $c) {
    $companiesByCity[$c['city']][] = $c;
}

foreach ($companies as $newRow) {
    $newId = $newRow['company_id'];
    $newName = $newRow['company_name'];
    $newAddress = $newRow['address'];
    $newCity = $newRow['city'];
    $newPin = $newRow['pincode'];

    $cityGroup = $companiesByCity[$newCity] ?? [];

    foreach ($cityGroup as $dbRow) {
        $dbId = $dbRow['company_id'];
        if ($newId >= $dbId) continue;

        // Fuzzy match only if pins match or addresses are similar
        $pinScore = ($newPin === $dbRow['pincode']) ? 100 : 0;
        if ($pinScore === 0) continue;

        $nameScore    = $this->fuzzyMatch($newName, $dbRow['company_name']);
        $addressScore = $this->fuzzyMatch($newAddress, $dbRow['address']);
        $cityScore    = $this->fuzzyMatch($newCity, $dbRow['city']);

        $totalScore = round(($nameScore + $addressScore + $cityScore + $pinScore) / 4);

        $matchingType = ($nameScore === 100 && $addressScore === 100 && $pinScore === 100) 
                        ? 'exact match' 
                        : ($totalScore >= 50 ? 'partial match' : 'no match');

        $passesMinimum = true && $nameScore >= 85 && $addressScore >= 70 && $cityScore >= 80 && $pinScore === 100;
        $isStrongMatch = $nameScore >= 80 && $addressScore >= 60 && $pinScore === 100;

       $companyScore = $totalScore; // Already computed in your matching loop
        $case = $this->determineCompanyCase($companyScore);

        switch ($case) {
            case 'exact':
                $this->handleExactCompany($newId, $dbId);
                break;
            case 'partial':
                $this->handleExactCompany($newId, $dbId);
                break;
            case 'no':
                $this->handleExactCompany($newId);
                break;
        }


    }
}

if (!empty($batch)) {
    $db->table('matching_session')->insertBatch($batch);
}

 // After your matching loop finishes
$matchingCount = $db->table('matching_session')->countAllResults();

if ($matchingCount === 0) {
    // No entries → redirect to company page
    return redirect()->to(base_url('company'));
}
    return $this->index();

// echo "Comparing $newId vs $dbId → $matchingType (Name=$nameScore, Address=$addressScore, Pin=$pinScore, Total=$totalScore)";
// exit;
    // -------------------- 3. Return results --------------------



}

protected function determineCompanyCase($companyScore)
{
    if ($companyScore === 100) {
        // Exact company match
        return 'exact';
    } elseif ($companyScore >= 50) {
        // Partial company match
        return 'partial';
    } else {
        // No company match
        return 'no';
    }
}

//Operations 
protected function determineCase($companyScore, $contactScore) {
    if ($companyScore === 100) {
        if ($contactScore === 100) return 1;
        if ($contactScore >= 50) return 3;
        return 2;
    } elseif ($companyScore >= 50) { // Partial company match
        if ($contactScore === 100) return 7;
        if ($contactScore >= 50) return 9;
        return 8;
    } else { // No company match
        if ($contactScore === 100) return 4;
        if ($contactScore >= 50) return 6;
        return 5;
    }
}

// Some Company Name Could be Same that Could be Different Entity this will result in Merge and Overwrite



protected function handleExactCompany($newId, $dbId) {
    // Case 1
    $this->overwriteCompany($newId, $dbId);

    // $this->overwriteCompany($newId, $dbId);
}

protected function handleExactCompanyNewContact($newId, $dbId) {
    // Case 2
    $this->addContactToCompany($newId, $dbId);
}

protected function handleExactCompanyPartialContact($newId, $dbId) {
    // Case 3
    $this->mergePartialContact($newId, $dbId);
}

protected function handleNoCompanyExactContact($newId, $dbId) {
    // Case 4
    $this->reviewContactCompanyMismatch($newId, $dbId);
}

protected function handleNoCompanyNoContact($newId, $dbId) {
    // Case 5
    $this->createNewCompanyAndContact($newId);
}

protected function handleNoCompanyPartialContact($newId, $dbId) {
    // Case 6
    $this->createNewCompanyWithPartialContactReview($newId, $dbId);
}

protected function handlePartialCompanyExactContact($newId, $dbId) {
    // Case 7
    $this->reviewCompanyMerge($newId, $dbId);
}

protected function handlePartialCompanyNewContact($newId, $dbId) {
    // Case 8
    $this->reviewCompanyWithNewContact($newId, $dbId);
}

protected function handlePartialCompanyPartialContact($newId, $dbId) {
    // Case 9
    $this->reviewHighRiskDuplicate($newId, $dbId);
}


///////////////////////////////////////////////////////

public function contactCrossValidation()
{
    $this->breakMultipleContacts();
    $db = \Config\Database::connect();
    $db->transStart();

    $contacts = $this->contactModel->findAll();
    $contactEmails = $db->table('contact_email')->get()->getResultArray();
    $contactMobiles = $db->table('contact_mobile')->get()->getResultArray();

    // Index emails/mobiles for fast lookup
    $emailsByContact = [];
    foreach ($contactEmails as $e) {
        $emailsByContact[$e['contact_id']][] = strtolower(trim($e['email']));
    }

    $mobilesByContact = [];
    foreach ($contactMobiles as $m) {
        $mobilesByContact[$m['contact_id']][] = trim($m['mobile']);
    }

    // Group contacts by company + normalized name
    $groups = [];
    foreach ($contacts as $c) {
        $key = $c['company_id'] . '|' . strtolower(trim($c['name']));
        $groups[$key][] = $c;
    }

    $deletedIds = [];

    foreach ($groups as $group) {
        if (count($group) <= 1) continue; // no duplicates

        // Take first as master
        $master = array_shift($group);
        $masterId = $master['contact_id'];

        $masterEmails = $emailsByContact[$masterId] ?? [];
        $masterMobiles = $mobilesByContact[$masterId] ?? [];

        foreach ($group as $dup) {
            $dupId = $dup['contact_id'];
            $dupEmails = $emailsByContact[$dupId] ?? [];
            $dupMobiles = $mobilesByContact[$dupId] ?? [];

            // Merge unique emails
            foreach ($dupEmails as $e) {
                if (!in_array($e, $masterEmails)) {
                    $masterEmails[] = $e;
                    $db->table('contact_email')->insert([
                        'contact_id' => $masterId,
                        'email'      => $e
                    ]);
                }
            }

            // Merge unique mobiles
            foreach ($dupMobiles as $m) {
                if (!in_array($m, $masterMobiles)) {
                    $masterMobiles[] = $m;
                    $db->table('contact_mobile')->insert([
                        'contact_id' => $masterId,
                        'mobile'     => $m
                    ]);
                }
            }

            // Delete duplicate contact
            $this->contactModel->delete($dupId);
            $deletedIds[] = $dupId;
        }
    }

    $db->transComplete();

return redirect()->to(site_url('company'));
}


    /**
     * Fuzzy match helper
     */
    private function fuzzyMatch($str1, $str2)
    {
        if (empty($str1) || empty($str2)) return 0;
        similar_text(strtolower($str1), strtolower($str2), $percent);
        return round($percent);
    }

    /**
     * Show results for both company & contact sessions
     */
    private function showMatchingResults()
    {
        $db = \Config\Database::connect();
        $companyMatches = $db->table('matching_session')->get()->getResultArray();
        $contactMatches = $db->table('matching_contact_session')->get()->getResultArray();

        return view('matching_session_view', [
            'company_matches' => $companyMatches,
            'contact_matches' => $contactMatches
        ]);
    }



public function handleAction()
{
    $request = $this->request->getPost();

    $type    = $request['type'] ?? null;        // company / contact
    $id      = $request['id'] ?? null;          // target ID
    $matchId = $request['match_id'] ?? null;    // matching ID
    $action  = $request['action'] ?? null;      // overwrite / merge / skip

    // ✅ Validate required parameters
    if (!$type || !$id || !$matchId || !$action) {
        return redirect()->back()->with('error', 'Missing required parameters.');
    }

    if ($id == $matchId) {
        return redirect()->back()->with('info', 'Target and matching ID are the same. No action taken.');
    }

    // -----------------------------
    // COMPANY LOGIC
    // -----------------------------
    if ($type === 'company') {

        // OVERWRITE using your existing method
        if ($action === 'overwrite') {
            $this->overwriteCompany($id, $matchId);
            return redirect()->back()->with('success', '✅ Company overwritten successfully.');
        }

        // MERGE logic
        if ($action === 'merge') {
            $targetCompany   = $this->companyModel->find($id);
            $matchingCompany = $this->companyModel->find($matchId);

            if (!$targetCompany || !$matchingCompany) {
                return redirect()->back()->with('error', 'Company not found.');
            }

            $this->companyModel->db->transStart();

            // Example: merge addresses
            $mergedAddress = trim($targetCompany['address'] . ', ' . $matchingCompany['address']);
            $this->companyModel->update($id, [
                'address'    => $mergedAddress,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Move related records
            $this->sourceModel
                ->where('company_id', $matchId)
                ->set(['company_id' => $id])
                ->update();

            $this->updationModel
                ->where('company_id', $matchId)
                ->set(['company_id' => $id])
                ->update();

            $this->companyModel->db->transComplete();

            if ($this->companyModel->db->transStatus() === false) {
                return redirect()->back()->with('error', 'Company merge failed.');
            }

            return redirect()->back()->with('success', '✅ Company merged successfully.');
        }

        // SKIP
        if ($action === 'skip') {
            return redirect()->back()->with('info', '⏭️ Company merge skipped.');
        }
    }

    // -----------------------------
    // CONTACT LOGIC
    // -----------------------------
    if ($type === 'contact') {

        if ($action === 'overwrite') {
            $this->overwriteContact($id, $matchId);
            return redirect()->back()->with('success', '✅ Contact overwritten successfully.');
        }

        if ($action === 'merge') {
            $merged = $this->mergeContact($id, $matchId);
            if ($merged) {
                return redirect()->back()->with('success', '✅ Contact merged successfully.');
            } else {
                return redirect()->back()->with('error', 'Contact merge failed (Name similarity < 80%).');
            }
        }

        if ($action === 'skip') {
            return redirect()->back()->with('info', '⏭️ Contact merge skipped.');
        }
    }

    return redirect()->back()->with('error', 'Invalid request.');
}


public function overwriteCompany(string $id, string $matchId): void
{
    echo "TYPE OK<br>";



    echo "ACTION OVERWRITE OK<br>";

    $this->companyModel->db->transStart();
    echo "TRANSACTION STARTED<br><hr>";

    // 1️⃣ Update source table
    $this->sourceModel
        ->where('company_id', $matchId)
        ->set('company_id', $id)
        ->update();
    echo "SOURCE UPDATED (company_id: $matchId → $id)<br>";
    

        $this->contactModel
        ->where('company_id', $matchId)
        ->set('company_id', $id)
        ->update();
    echo "Contact UPDATED (company_id: $matchId → $id)<br>";

    // 2️⃣ Update updation table
    $this->updationModel
        ->where('company_id', $matchId)
        ->set('company_id', $id)
        ->update();
    echo "UPDATION UPDATED (company_id: $matchId → $id)<br><hr>";

        // 1️⃣ Update source table
    $this->leadModel
        ->where('company_id', $matchId)
        ->set('company_id', $id)
        ->update();
    echo "leadModel UPDATED (company_id: $matchId → $id)<br>";


    // 3️⃣ Fetch BEFORE data
    $before = $this->companyModel->find($id);
    echo "<strong>BEFORE DATA:</strong><br><pre>";
    print_r($before);
    echo "</pre><hr>";

    if (!$before) {
        echo "❌ COMPANY NOT FOUND<br>";
        exit;
    }

    $matchingCompany = $this->companyModel->find($matchId);

    // 4️⃣ Prepare update data (debug)
    echo "<strong>UPDATE DATA USED:</strong><br><pre>";
    print_r([
        'company_name' => $matchingCompany['company_name'] ?? $before['company_name'],
        'category'     => $matchingCompany['category'] ?? $before['category'],
        'address'      => $matchingCompany['address'] ?? $before['address'],
        'city'         => $matchingCompany['city'] ?? $before['city'],
        'pincode'      => $matchingCompany['pincode'] ?? $before['pincode'],
        'state'        => $matchingCompany['state'] ?? $before['state'],
        'Cross'        => $matchingCompany['cross_validation'] ?? $before['cross_validation'],
    ]);
    echo "</pre><hr>";

    $newData = $this->companyModel->find($matchId);
    echo $id;
    echo $matchId;

    // 5️⃣ Update main company
    $this->companyModel->update($id, [
        'company_name'      => $newData['company_name'] ?? $before['company_name'],
        'category'          => $newData['category'] ?? $before['category'],
        'address'           => $newData['address'] ?? $before['address'],
        'city'              => $newData['city'] ?? $before['city'],
        'pincode'           => $newData['pincode'] ?? $before['pincode'],
        'state'             => $newData['state'] ?? $before['state'],
        'updated_at'        => date('Y-m-d H:i:s'),
        'cross_validation'  => "0",
    ]);

    echo "COMPANY UPDATED<br><hr>";

    // 6️⃣ Update matching company
    $this->companyModel->update($matchId, [
        'company_name'      => $newData['company_name'] ?? $before['company_name'],
        'category'          => $newData['category'] ?? $before['category'],
        'address'           => $newData['address'] ?? $before['address'],
        'city'              => $newData['city'] ?? $before['city'],
        'pincode'           => $newData['pincode'] ?? $before['pincode'],
        'state'             => $newData['state'] ?? $before['state'],
        'updated_at'        => date('Y-m-d H:i:s'),
        'cross_validation'  => true,
    ]);

    // 7️⃣ Fetch AFTER data
    $after = $this->companyModel->find($id);
    echo "<strong>AFTER DATA:</strong><br><pre>";
    print_r($after);
    echo "</pre><hr>";

    $newData = $this->companyModel->find($matchId);
    print_r($newData);
// Delete the company record with the given $matchId
$this->companyModel->delete($matchId);

    // 8️⃣ Delete matching session
    $this->matchingSessionModel
        ->where('company_id', $id)
        ->where('matching_company_id', $matchId)
        ->delete();
    echo "MATCHING SESSION DELETED<br><hr>";

    // 9️⃣ Complete transaction
    $this->companyModel->db->transComplete();
    echo "TRANSACTION COMPLETED<br>";

    if ($this->companyModel->db->transStatus() === false) {
        echo "❌ TRANSACTION FAILED<br>";
        exit;
    }

    echo "<strong>✅ OVERWRITE FLOW FINISHED SUCCESSFULLY</strong><br>";
}



public function mergeContact($contactId, $matchedContactId)
{
    $contactModel = new \App\Models\ContactModel();
    $mobileModel  = new \App\Models\ContactMobileModel();
    $emailModel   = new \App\Models\ContactEmailModel();

    // Fetch both contacts
    $original = $contactModel->find($contactId);
    $matched  = $contactModel->find($matchedContactId);

    if (!$original || !$matched) {
        return false;
    }

    /*
    --------------------------------------------------
    1️⃣ NAME SIMILARITY CHECK (80%)
    --------------------------------------------------
    */
    similar_text(
        strtolower($original['name']),
        strtolower($matched['name']),
        $percent
    );

    if ($percent < 80) {
        return false; // stop if not similar enough
    }

    /*
    --------------------------------------------------
    2️⃣ MERGE EMAILS
    --------------------------------------------------
    */
    $originalEmails = $emailModel->where('contact_id', $contactId)->findAll();
    $matchedEmails  = $emailModel->where('contact_id', $matchedContactId)->findAll();

    $existingEmails = array_map(
        fn($e) => strtolower(trim($e['email'])),
        $originalEmails
    );

    foreach ($matchedEmails as $mEmail) {

        $email = strtolower(trim($mEmail['email']));

        if (!in_array($email, $existingEmails)) {
            $emailModel->insert([
                'contact_id' => $contactId,
                'email'      => $email,
                'is_primary' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /*
    --------------------------------------------------
    3️⃣ MERGE MOBILES (Normalize)
    --------------------------------------------------
    */
    $originalMobiles = $mobileModel->where('contact_id', $contactId)->findAll();
    $matchedMobiles  = $mobileModel->where('contact_id', $matchedContactId)->findAll();

    $normalize = function ($number) {
        return preg_replace('/[^0-9]/', '', $number);
    };

    $existingMobiles = array_map(
        fn($m) => $normalize($m['mobile']),
        $originalMobiles
    );

    foreach ($matchedMobiles as $mMobile) {

        $normalized = $normalize($mMobile['mobile']);

        if (!in_array($normalized, $existingMobiles)) {
            $mobileModel->insert([
                'contact_id' => $contactId,
                'mobile'     => $mMobile['mobile'],
                'is_primary' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /*
    --------------------------------------------------
    4️⃣ OPTIONAL: DELETE DUPLICATE
    --------------------------------------------------
    */
    $contactModel->delete($matchedContactId);

    return true;
}

public function fixEmailMobileMixup()
{
    $contactModel = new \App\Models\ContactModel();
    $emailModel   = new \App\Models\ContactEmailModel();
    $mobileModel  = new \App\Models\ContactMobileModel();
    $db = \Config\Database::connect();

    $db->transStart();

    // 1️⃣ Fix emails that contain numbers only (likely mobiles)
    $emails = $emailModel->findAll();
    foreach ($emails as $e) {
        $emailValue = trim($e['email']);

        // If it looks like a mobile (numbers, maybe spaces, +, -, parentheses)
        if (preg_match('/^[\d\s\+\-\(\)]+$/', $emailValue)) {
            // Insert into mobiles if not already there
            $exists = $mobileModel->where('contact_id', $e['contact_id'])
                                  ->where('mobile', $emailValue)
                                  ->countAllResults();

            if (!$exists) {
                $mobileModel->insert([
                    'contact_id' => $e['contact_id'],
                    'mobile' => $emailValue,
                    'is_primary' => 1
                ]);
            }

            // Delete from email table
            $emailModel->delete($e['email_id']);
        }
    }

    // 2️⃣ Fix mobiles that contain "@" (likely emails)
    $mobiles = $mobileModel->findAll();
    foreach ($mobiles as $m) {
        $mobileValue = trim($m['mobile']);

        if (filter_var($mobileValue, FILTER_VALIDATE_EMAIL)) {
            // Insert into emails if not already there
            $exists = $emailModel->where('contact_id', $m['contact_id'])
                                 ->where('email', $mobileValue)
                                 ->countAllResults();

            if (!$exists) {
                $emailModel->insert([
                    'contact_id' => $m['contact_id'],
                    'email' => $mobileValue,
                    'is_primary' => 1
                ]);
            }

            // Delete from mobile table
            $mobileModel->delete($m['mobile_id']);
        }
    }

    $db->transComplete();

    return "✅ Checked and corrected email/mobile mixups.";
}

public function breakMultipleContacts()
{ 
    $this->fixEmailMobileMixup();
    $contactModel = new \App\Models\ContactModel();
    $mobileModel  = new \App\Models\ContactMobileModel();
    $emailModel   = new \App\Models\ContactEmailModel();
    $db = \Config\Database::connect();

    // Start transaction
    $db->transStart();

    // 1️⃣ Fetch all contacts with "/" in name
    $contacts = $contactModel->like('name', '/')->findAll();
    if (empty($contacts)) return "No contacts to split.";

    // 2️⃣ Fetch all related emails & mobiles once
    $contactIds = array_column($contacts, 'contact_id');
    $emails = $emailModel->whereIn('contact_id', $contactIds)->findAll();
    $mobiles = $mobileModel->whereIn('contact_id', $contactIds)->findAll();

    // Index emails & mobiles by contact_id
    $emailsByContact = [];
    foreach ($emails as $e) {
        $emailsByContact[$e['contact_id']][] = $e['email'];
    }

    $mobilesByContact = [];
    foreach ($mobiles as $m) {
        $mobilesByContact[$m['contact_id']][] = $m['mobile'];
    }

    $newContacts = [];
    $newEmails = [];
    $newMobiles = [];
    $toDeleteContacts = [];

    foreach ($contacts as $contact) {
        $originalId = $contact['contact_id'];

        // Split names & designations
        $names = array_map('trim', explode('/', $contact['name']));
        $designations = array_map('trim', explode('/', $contact['designation'] ?? ''));

        // Flatten emails and mobiles
        $emailList = [];
        foreach ($emailsByContact[$originalId] ?? [] as $e) {
            $parts = preg_split('/[\/,]/', $e);
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p) $emailList[] = $p;
            }
        }

        $mobileList = [];
        foreach ($mobilesByContact[$originalId] ?? [] as $m) {
            $parts = preg_split('/[\/,]/', $m);
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p) $mobileList[] = $p;
            }
        }

        // Assign emails and mobiles sequentially
        foreach ($names as $i => $name) {
            $newContactData = [
                'company_id' => $contact['company_id'],
                'priority'   => $contact['priority'],
                'name'       => $name,
                'designation'=> $designations[$i] ?? null,
            ];
            $newContacts[] = $newContactData;

            $newEmails[] = [
                'contact_index' => count($newContacts) - 1,
                'email' => $emailList[$i] ?? null
            ];

            $newMobiles[] = [
                'contact_index' => count($newContacts) - 1,
                'mobile' => $mobileList[$i] ?? null
            ];
        }

        $toDeleteContacts[] = $originalId;
    }

    // 3️⃣ Insert new contacts and store IDs
    $insertedIds = [];
    foreach ($newContacts as $nc) {
        $insertedIds[] = $contactModel->insert($nc);
    }

    // 4️⃣ Insert new emails
    foreach ($newEmails as $ne) {
        if ($ne['email']) {
            $emailModel->insert([
                'contact_id' => $insertedIds[$ne['contact_index']],
                'email' => $ne['email'],
                'is_primary' => 1
            ]);
        }
    }

    // 5️⃣ Insert new mobiles
    foreach ($newMobiles as $nm) {
        if ($nm['mobile']) {
            $mobileModel->insert([
                'contact_id' => $insertedIds[$nm['contact_index']],
                'mobile' => $nm['mobile'],
                'is_primary' => 1
            ]);
        }
    }

    // 6️⃣ Delete original messy contacts and related emails/mobiles
    if ($toDeleteContacts) {
        $contactModel->whereIn('contact_id', $toDeleteContacts)->delete();
        $emailModel->whereIn('contact_id', $toDeleteContacts)->delete();
        $mobileModel->whereIn('contact_id', $toDeleteContacts)->delete();
    }

    $db->transComplete();

    return "✅ Contacts split successfully. Created " . count($newContacts) . " new contacts.";
}


// Case 1 exhact company name and Address and pin and city 

// case 2  exhaction comapny name but address is differnt

// case 3 exhact company name and address and city but differnt city 



}



