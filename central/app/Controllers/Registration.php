<?php

namespace App\Controllers;

use CodeIgniter\Controller;
// use App\Models\LeadsModel;
use App\Models\CompanyModel;
// use App\Models\LeadLocationsModel;
// use App\Models\ContactModel;
// use App\Models\ContactEmailModel;
// use App\Models\ContactMobileModel;
// use App\Models\CompanySourcesModel;
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

    
}