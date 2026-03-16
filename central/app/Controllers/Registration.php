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
                        $eventYear = $events[0]['year'] ?? date('Y');

        $data = [
        // 'events'     => $events,
        // 'location'   => $city,
        'eventYear'  => $eventYear,
        'citySuffix' => "none", // Pass this to the view
        // 'title'      => 'Trade Visitor Registration - ' . ucfirst($city)
    ];

        // Example: list all leads

        return view('registration/index',$data);
    }

    public function publicformtradevisitor($location = null)
{
    // Normalize city
    $allowedCities = ['ahmedabad', 'mumbai', 'delhi', 'bangalore', 'kochi', 'pune', 'hyderabad', 'chennai', 'kolkata'];
    $city = strtolower(trim((string)$location));

    // Check if city is allowed
    if (!in_array($city, $allowedCities)) {
        // Option 1: Show 403 Forbidden page
        throw \CodeIgniter\Exceptions\PageForbiddenException::forPage();

        // Option 2: Redirect to a safe page (uncomment if you prefer redirect)
        // return redirect()->to(base_url('/not-allowed'));
    }
    
    var_dump($city);
    $events = [];
    $eventYear = date('Y'); 
    $citySuffix = $city; // Default to the location parameter

    if (!empty($city) && in_array($city, $allowedCities)) {
        $eventModel = new \App\Models\EventModel();
        $events = $eventModel->like('name', $city)->findAll();
    }

    if (!empty($events)) {
        // 1. Extract the City Suffix (e.g., "IITM AHMEDABAD" becomes "ahmedabad")
        $rawName = $events[0]['name'];
        $citySuffix = trim(str_ireplace('IITM', '', $rawName));
        $citySuffix = strtolower($citySuffix);

        // 2. Get the Year
        $eventYear = $events[0]['year'] ?? date('Y');
    }

    $data = [
        'events'     => $events,
        'location'   => $city,
        'eventYear'  => $eventYear,
        'citySuffix' => $citySuffix, // Pass this to the view
        'title'      => 'Trade Visitor Registration - ' . ucfirst($city)
    ];

    var_dump($data); // Debug: Check the data being passed to the view
    
    return view('registration/eventoverview', $data);
}


    public function mobile($location = null)
{

    $allowedCities = ['ahmedabad', 'mumbai', 'delhi', 'bangalore', 'kochi', 'pune', 'hyderabad','chennai','kolkata'];
    $city = strtolower(trim((string)$location));
    
    $events = [];
    $eventYear = date('Y'); 
    $citySuffix = "x"; // Default to the location parameter

    if (!empty($city) && in_array($city, $allowedCities)) {
        $eventModel = new \App\Models\EventModel();
        $events = $eventModel->like('name', $city)->findAll();
    }

    if (!empty($events)) {
        // 1. Extract the City Suffix (e.g., "IITM AHMEDABAD" becomes "ahmedabad")
        $rawName = $events[0]['name'];
        $citySuffix = trim(str_ireplace('IITM', '', $rawName));
        $citySuffix = strtolower($citySuffix);

        // 2. Get the Year
        $eventYear = $events[0]['year'] ?? date('Y');
    }
if($location == "x"){
$error = "";

}else{
    $error = "Number is Not Registered";
}

    $data = [
        'events'     => $events,
        'location'   => $city,
        'eventYear'  => $eventYear,
        'citySuffix' => $citySuffix, // Pass this to the view
        'title'      => 'Trade Visitor Registration - ' . ucfirst($city),
        'error'      => $error,
    ];

    // var_dump($data); // Debug: Check the data being passed to the view
    var_dump($data);
    return view('registration/mobile', $data);
}

public function publicformspot()
{
    $this->db = \Config\Database::connect();
    $today = date('Y-m-d');

    $upcomingEvents = $this->db->table('events')
        ->select('event_id, name, year, venue_details')
        ->where('start_date >=', $today)
        ->orderBy('start_date', 'ASC')
        ->get()
        ->getResultArray();

//     echo "<pre>";
// var_dump($upcomingEvents);
// echo "</pre>";
// exit;
    // 1. Initialize the variable
    $citySuffix = 'TBA'; 
// In your publicformspot() function
// $citySuffix = 'TBA';
$eventYear  = date('Y'); // Fallback to current year

if (!empty($upcomingEvents)) {
    // 1. Get the City from "IITM AHMEDABAD"
    $citySuffix = trim(str_ireplace('IITM', '', $upcomingEvents[0]['name']));
    $citySuffix = strtolower($citySuffix);

    // 2. Get the Year directly from the database row (e.g., "2026")
    $eventYear = $upcomingEvents[0]['year'];
}

$data = [
    'events'     => $upcomingEvents,
    'citySuffix' => $citySuffix,
    
    'eventYear'  => $eventYear
];
echo "<pre>";
var_dump($data);
echo "</pre>";
    // exit;

return view('registration/spot', $data);
}
    
public function publicformexhibitor()
    {
        // Example: list all leads
        return view('registration/exhibitor');
    }



 public function spotform()
    {
        // Example: list all leads
        // use db get events where start date is gretea that current date and name 
        
        return view('registration/spotform');
    }


public function regitersuccess($data = null, $number = null)
{

// var_dump($data, $number);
// exit;
    $MobileModel = new \App\Models\ContactMobileModel();
    $contact     = $MobileModel->where('mobile', $number)->first();
    $contactId   = $contact['contact_id'] ?? 0;

// 1. Explode the string by the hyphen
$parts = explode('-', (string)$data);

// 2. Get the last element of the array
$citySuffix = end($parts);


// var_dump($citySuffix); 
// Output: string(4) "pune";
// exit;
    $alldata = $this->getgataforprint($citySuffix,$contactId, 'form');
    // 1. Extract the city from the string (e.g., 'onlinetradevisitor-KOLKATA')
    $parts = explode('-', (string)$data);
    $citySuffix = isset($parts[2]) ? $parts[2] : $data; 

    // 2. Pass ONLY the city suffix to the helper
    $events = $this->getEventsByCity($citySuffix);

    $viewData = [
        'type'    => strtolower($parts[0]),
        'mobile'  => $number,
        'alldata' => $alldata,
        'event'   => $events, 
    ];
    // var_dump($alldata);
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
if ($viewData['alldata']['companyName'] === 'Not_Found') {
    return redirect()->to('https://iitmindia.com');
}

    // var_dump($viewData);
    // exit;
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


    public function searchentry($location, $mobileargument = null)
{
    // var_dump($location, $mobileargument);
    // exit;
    $allowedLocations = [
        'ahmedabad', 'mumbai', 'delhi', 
        'bangalore', 'kochi', 'pune', 'hyderabad', 'chennai', 'kolkata'
    ];

    // Normalize to lowercase
    $location = strtolower($location);

    // Validate location
    if (!in_array($location, $allowedLocations)) {
        return redirect()->back()->with('error', 'Invalid location specified.');
    }

    // Get mobile number either from argument or POST
    $mobile = $mobileargument ?? $this->request->getPost('mobile');

    if (!$mobile) {
        return redirect()->back()->with('error', 'Mobile number is required.');
    }

    $MobileModel = new \App\Models\ContactMobileModel();

    // Search contact by mobile
$contact = $MobileModel
    ->select('contact_mobile.mobile_id, contact_mobile.contact_id, contact_mobile.mobile, 
              contact.name AS contact_name, contact.designation, 
              company_data.company_id, company_data.company_name, company_data.entry_type')
    ->join('contact', 'contact.contact_id = contact_mobile.contact_id', 'inner')
    ->join('company_data', 'company_data.company_id = contact.company_id', 'inner')
    ->where('contact_mobile.mobile', $mobile)
    ->where('company_data.entry_type', 'main')
    ->first();


    // get company data 
    // // get the contact name desination current number and email

    // when person register on spot they should automatically get into participants but no copy for main 



    // if entrytype = participants and database = spot 
    // spot registration save in participant 
    // database = Year Location - TV
    // source = spot 


    // if online registration comes and verify at venue 
    // cretae entry 
    // participant
    // database = Year Location - TV
    // source = online registration 

    // no let the spot create a copy in main with database as Spot and source as YEAR - Location - TV 
    // spot registration 
    // online registration 
    // verfication 
    // spot -a copy in main
    // online whoever i have search add a 


    // participant year-location-TV spot 
    // var_dump($location, $mobile);

    if (!$contact) {
        return $this->getgataforprint($location,0); // no contact found
    }

    
    $data = $this->getgataforprint($location,$contact['contact_id']);

    return view('registration/spotinterface', $data);
}


public function getgataforprint($location = null, $contactId = 1, $for = 'print')
{

if($location != 'exhibitor'){
// var_dump($location, $contactId, $for);
    // exit;
    $allowedLocations = [
        'ahmedabad', 'mumbai', 'delhi', 
        'bangalore', 'kochi', 'pune', 'hyderabad', 'chennai', 'kolkata','none'
    ];

    // Normalize and validate location
    $location = strtolower($location ?? '');
    if (!in_array($location, $allowedLocations)) {
        return redirect()->back()->with('error', 'Invalid location specified.');
    }

}
else{
    $location = "null";


}
    

    // Default data structure
    $data = [
        'contactName' => 'Not_Found',
        'companyName' => 'Not_Found',
        'designation' => '',
        'mobile'      => '',
        'email'       => '',
        'sources'     => [],
        'location'    => $location, // pass location to view if needed
    ];

    // ── Contact not found ─────────────────────────────
    if ($contactId == 0) {
        return $for == 'form'
            ? $data
            : view('registration/spotinterface', $data);
    }

    // ── Hardcoded test case ──────────────────────────
    if ($contactId == 1) {
        $data['contactName']  = "Nishant Vishwakarma";
        $data['companyName']  = "Sphere Travel Media";
        return $for == 'form'
            ? $data
            : view('registration/spotinterface', $data);
    }

    // ── Real lookup ─────────────────────────────────
    $contactModel = new \App\Models\ContactModel();
    $companyModel = new \App\Models\CompanyModel();
    $sourceModel  = new \App\Models\SourceModel();

    $contact = $contactModel->find($contactId);
    // var_dump($contact);
    // exit;

    if ($contact) {
        $company = $companyModel
            ->where('company_id', $contact['company_id'])
            ->first();

        $data = [
            'contactName' => strtoupper($contact['name'] ?? 'Unknown Contact'),
            'companyName' => strtoupper($company['company_name'] ?? 'Unknown Company'),
            'designation' => strtoupper($contact['designation'] ?? ''),
            'mobile'      => $contact['mobile'] ?? '',
            'email'       => $contact['email'] ?? '',
            'sources'     => [],
            'location'    => $location,
        ];

        // var_dump($company);
        // exit;
        // Insert into company_sources

            $insertData = [
                'company_id' => $company['company_id'],
                'event_date' => date('Y-m-d H:i:s'),
'notes' => 'IITM-' . $location . '-' . date('Y')                ];
            $sourceModel->addSource($insertData);
    }

    return $data;
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