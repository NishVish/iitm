<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LeadModel;
use App\Models\LeadLocationModel;
use App\Models\CompanyModel;
use App\Models\EventModel;
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
public function publicformtradevisitor($location = null)
{
    $allowedCities = [
        'ahmedabad', 'mumbai', 'delhi', 
        'bangalore', 'kochi', 'pune', 'hyderabad','chennai','kolkata'
    ];

    // 1. Sanitize and validate the city
    $city = strtolower(trim((string)$location));

    // 2. Initialize empty events array
    $events = [];

    // 3. Only query if the city is in our whitelist
    if (!empty($city) && in_array($city, $allowedCities)) {
        $eventModel = new \App\Models\EventModel();
        // Get the actual data from the database
        $events = $eventModel->like('name', $city)->findAll();
    }

    // 4. Prepare data for the view
    $data = [
        'events'   => $events,
        'location' => $city,
        'title'    => 'Trade Visitor Registration - ' . ucfirst($city)
    ];

    // var_dump($data);
    // exit;

    return view('registration/tradevisitor', $data);
}



public function publicformspot()
    {
        // Example: list all leads
        return view('registration/spot');
    }
    
public function publicformexhibitor()
    {
        // Example: list all leads
        return view('registration/exhibitor');
    }



 public function spotform()
    {
        // Example: list all leads
        return view('registration/spotform');
    }


public function regitersuccess($data = null, $number = null)
{

    $MobileModel = new \App\Models\ContactMobileModel();
    $contact     = $MobileModel->where('mobile', $number)->first();
    $contactId   = $contact['contact_id'] ?? 0;

    $alldata = $this->getgataforprint($contactId, 'form');
    // 1. Extract the city from the string (e.g., 'onlinetradevisitor-KOLKATA')
    $parts = explode('-', (string)$data);
    $citySuffix = isset($parts[1]) ? $parts[1] : $data; 

    // 2. Pass ONLY the city suffix to the helper
    $events = $this->getEventsByCity($citySuffix);

    $viewData = [
        'type'    => strtolower($parts[0]),
        'mobile'  => $number,
        'alldata' => $alldata,
        'event'   => $events, 
    ];
    // var_dump($viewData);
// Check if it's a 'spot' registration and data was not found
if ($viewData['type'] === 'spot' && 
    $viewData['alldata']['contactName'] === 'Not_Found' && 
    (
    $viewData['alldata']['companyName'] === 'Not_Found' ||
    $viewData['alldata']['companyName'] === 'UNKNOWN COMPANY' )) {
    
    // Return the specific view for public spot registration
    return $this->publicformspot();
}

// Otherwise, proceed to the standard success/badge view
    if($data == "exhibitor"){

            return view('registration/thankyouexhibitor',$viewData);


    }
    

    // var_dump($viewData);
    // exit;
    return view('registration/success', $viewData);
}

/**
 * Standalone logic to fetch events based on allowed city keywords
 */


private function getEventsByCity($cityInput): array
{
    if (empty($cityInput)) {
        return [];
    }

    $allowedCities = [
        'ahmedabad', 'mumbai', 'delhi', 
        'bangalore', 'kochi', 'pune', 'hyderabad','kolkata'
    ];

    // Sanitize input
    $city = strtolower(trim((string)$cityInput));

    // Check whitelist
    if (in_array($city, $allowedCities)) {
        $eventModel = new \App\Models\EventModel();
        // Use like() to find the city name within the event record
        return $eventModel->like('name', "iitm ".$city)->findAll();
    }

    return [];
}

// // ✅ Controller catches both
// public function regitersuccess($data = null, $number = null)
// {
//     // Directly get contact ID from mobile, don't call searchentry()
//     $MobileModel = new \App\Models\ContactMobileModel();
//     $contact     = $MobileModel->where('mobile', $number)->first();
//     $contactId   = $contact['contact_id'] ?? 0;

//     $alldata = $this->getgataforprint($contactId, 'form');

//     $viewData = [
//         'type'    => $data,
//         'mobile'  => $number,
//         'alldata' => $alldata,
//     ];


//     $eventModel = new \App\Models\EventModel();

// $allowedCities = [
//     'ahmedabad', 'mumbai', 'delhi', 
//     'bangalore', 'kochi', 'pune', 'hyderabad'
// ];


// // Example: $type coming from URI, form, or input
// $data = strtolower($data); // convert to lowercase for matching
// var_dump($data);
// if (in_array($data, $allowedCities)) {
//     // Query EventModel where event_name matches $type
//     $events = $eventModel->like('name', $data)->findAll();

//     $viewData = [
//         'type'    => $data,
//         'mobile'  => $number,
//         'alldata' => $alldata,
//         'event' => $events,
//     ];
//     // var_dump($events);
//     // exit;
//     return view('registration/success', $viewData);
// }
    


   
// }

    public function searchentry($mobileargument = Null)
{
    if($mobileargument == Null){
    
    $mobile = $this->request->getPost('mobile');
    // $mobile = 1;

    }else{

        $mobile = $mobileargument;
    }
    if (!$mobile) {
        return redirect()->back()->with('error', 'Mobile number is required.');
    }

    $MobileModel = new \App\Models\ContactMobileModel();

    // Search contact by mobile
    $contact = $MobileModel->where('mobile', $mobile)->first();

    if (!$contact) {

    return $this->getgataforprint(0);
    }

    // var_dump( $contact);
    // exit;
    // Redirect to spotinterface with contactId
    return $this->getgataforprint($contact['contact_id']);
}


public function getgataforprint($contactId = 1, $for = 'print')
{
    $data = [
        'contactName' => 'Not_Found',
        'companyName' => 'Not_Found',
        'designation' => '',
        'mobile'      => '',
        'email'       => '',
        'sources'     => [],
    ];

    // ── contact not found ─────────────────────────────────────────────────────
    if ($contactId == 0) {
        return $for == 'form'
            ? $data
            : view('registration/spotinterface', $data);
    }

    // ── hardcoded test case ───────────────────────────────────────────────────
    if ($contactId == 1) {
        $data['contactName'] = "Nishant Vishwakarma";
        $data['companyName'] = "Sphere Travel Media";
        return $for == 'form'
            ? $data
            : view('registration/spotinterface', $data);
    }

    // ── real lookup ───────────────────────────────────────────────────────────
    $contactModel = new \App\Models\ContactModel();
    $companyModel = new \App\Models\CompanyModel();
    $sourceModel  = new \App\Models\SourceModel();

    $contact = $contactModel->find($contactId);

    if ($contact) {
$company = $companyModel
            ->where('company_id', $contact['company_id'])
            ->first();
        // var_dump($company);
        // exit;
        $data = [
            'contactName' => strtoupper($contact['name']              ?? 'Unknown Contact'),
            'companyName' => strtoupper($company['company_name']      ?? 'Unknown Company'),
            'designation' => strtoupper($contact['designation']       ?? ''),
            'mobile'      => $contact['mobile'] ?? '',
            'email'       => $contact['email']  ?? '',
            'sources'     => [],
        ];

        // Insert into company_sources
        $insertData = [
            'company_id' => $contact['company_id'],
            'event_date' => date('Y-m-d H:i:s'),
            'notes'      => 'spot'
        ];

        if (!empty($insertData['company_id'])) {
            $sourceModel->addSource($insertData);
        }
    }

    return $for == 'form'
        ? $data
        : view('registration/spotinterface', $data);
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