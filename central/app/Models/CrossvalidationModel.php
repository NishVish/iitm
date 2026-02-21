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

class CrossValidationModel extends Controller
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