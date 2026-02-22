<?php

namespace App\Controllers;

use CodeIgniter\Controller;
// use App\Models\LeadsModel;
use App\Models\CompanyModel;
// use App\Models\LeadLocationsModel;
use App\Models\ContactModel;
use App\Models\SourceModel;
use App\Models\ContactMobileModel;

// use App\Models\UpdationModel;

class Registration extends BaseController
{
    // protected $leadsModel;
    // protected $locationsModel;
    // protected $contactModel;
    // protected $contactEmailModel;
    // protected $contactMobileModel;
    // protected $companySourcesModel;
    // protected $updationModel;

    public function __construct()
    {
        // $this->leadsModel = new LeadsModel();
        // $this->locationsModel = new LeadLocationsModel();
        // $this->contactModel = new ContactModel();
        // $this->contactEmailModel = new ContactEmailModel();
        // $this->contactMobileModel = new ContactMobileModel();
        // $this->companySourcesModel = new CompanySourcesModel();
        // $this->updationModel = new UpdationModel();
    }

    public function index()
    {
        // Example: list all leads
        return view('registration/index');
    }
public function publicformtradevisitor()
    {
        // Example: list all leads
        return view('registration/tradevisitor');
    }
public function publicformexhibitor()
    {
        // Example: list all leads
        return view('registration/exhibitor');
    }

public function generatebadge($company_id)
{
    $companyModel = new \App\Models\CompanyModel();

    // Fetch company name and first contact
    $data = $companyModel->getPersonAndCompany($company_id);

    if (!$data) {
        return "Company not found";
    }

    // Pass data to view
    return view('registration/badge', [
        'company_id'   => $company_id,
        'company_name' => $data['company_name'],
        'contact_name' => $data['contact_name']
    ]);


}
public function thanksforregister()
    {
        // Example: list all leads
        return view('registration/thanks');
    }

    
    public function spotform()
    {
        // Example: list all leads
        return view('registration/spotform');
    }


    public function searchentry()
{
    $mobile = $this->request->getPost('mobile');
    // $mobile = 1;

    if (!$mobile) {
        return redirect()->back()->with('error', 'Mobile number is required.');
    }

    $MobileModel = new \App\Models\ContactMobileModel();

    // Search contact by mobile
    $contact = $MobileModel->where('mobile', $mobile)->first();

    if (!$contact) {

    return $this->spotinterface(0);
    }

    // var_dump( $contact);
    // exit;
    // Redirect to spotinterface with contactId
    return $this->spotinterface($contact['contact_id']);
}



public function spotinterface($contactId = null)
{
    // Initialize data array
    $data = [
        'contactName' => 'Not_Found',
        'companyName' => 'Not_Found',
        'designation' => '',
        'mobile'      => '',
        'email'       => '',
        'sources'     => [],
    ];

    if ($contactId == 0) {
        return view('registration/spotinterface', $data);
    }

    // Hardcoded for testing
    if ($contactId == 1) {
        $data['contactName'] = "Nishant Vishwakarma";
        $data['companyName'] = "Sphere Travel Media";
        return view('registration/spotinterface', $data);
    }

    // Load models
    $contactModel = new \App\Models\ContactModel();
    $companyModel = new \App\Models\CompanyModel();
    $sourceModel  = new \App\Models\SourceModel();

    // Fetch contact
    $contact = $contactModel->find($contactId);

    if ($contact) {
        // Fetch company
        $company = $companyModel->find($contact['company_id'] ?? null);

        $data = [
            'contactName' => strtoupper($contact['name'] ?? 'Unknown Contact'),
            'companyName' => strtoupper($company['company_name'] ?? 'Unknown Company'),
            'designation' => strtoupper($contact['designation'] ?? ''),
            'mobile'      => $contact['mobile'] ?? '',
            'email'       => $contact['email'] ?? '',
        ];

        // --- Insert into company_sources ---
        $insertData = [
            'company_id' => $contact['company_id'],
            'event_date' => date('Y-m-d H:i:s'),
            'notes'      => 'spot'
        ];

        if (!empty($insertData['company_id'])) {
            $sourceModel->addSource($insertData);
        }
    }

    return view('registration/spotinterface', $data);
}



}