<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LeadModel;
use App\Models\LeadLocationModel;
use App\Models\CompanyModel;
// use App\Models\LeadLocationsModel;
use App\Models\ContactModel;
use App\Models\SourceModel;
use App\Models\ContactMobileModel;
use App\Models\ContactEmailModel;

use \App\Model\AlldetailsModel;

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
public function registrationview($source, $timerange = null)
{
    // ✅ Use AlldetailsModel to get all company details
    $alldetailsModel = new \App\Models\AlldetailsModel();

    // Fetch all companies and their related data
    $data = $alldetailsModel->getAllCompanyDetails($source, $timerange);

    // Pass the data to the view
    return view('registration/registrationview', ['companies' => $data]);
}

//     public function registrationview($type = null)
// {
//     // Dummy Lead
//     $data['lead'] = [
//         'lead_id'        => 1,
//         'company_id'     => 'COMP001',
//         'exhibitor'      => 'ABC Industries',
//         'sales_person'   => 'John Doe',
//         'status'         => 'confirmed',
//         'payment_status' => 'paid'
//     ];

//     // Dummy Contact
//     $data['contact'] = [
//         'name'        => 'Rahul Sharma',
//         'designation' => 'Marketing Manager'
//     ];

//     // Dummy Emails
//     $data['emails'] = [
//         ['email' => 'rahul@abc.com'],
//         ['email' => 'info@abc.com']
//     ];

//     // Dummy Mobiles
//     $data['mobiles'] = [
//         ['mobile' => '9876543210'],
//         ['mobile' => '9123456780']
//     ];

//     // Dummy Stall Locations
//     $data['locations'] = [
//         [
//             'location'        => 'Hall A',
//             'stall_location'  => 'A12',
//             'size'            => '3x3',
//             'price'           => 50000,
//             'gst_amount'      => 9000,
//             'discount_amount' => 2000,
//             'grand_total'     => 57000
//         ],
//         [
//             'location'        => 'Hall B',
//             'stall_location'  => 'B05',
//             'size'            => '6x3',
//             'price'           => 90000,
//             'gst_amount'      => 16200,
//             'discount_amount' => 5000,
//             'grand_total'     => 101200
//         ]
//     ];

//     return view('registration/registrationview', $data);
// }


}