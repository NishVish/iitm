<?php

namespace App\Controllers;

use App\Models\LeadModel;
use App\Models\LeadLocationModel;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\UpdationModel;
use App\Models\SourceModel;
use App\Models\DiscussionModel;

class Leads extends BaseController
{
    
public function index()
{
    $location    = $this->request->getGet('location');
    $year        = $this->request->getGet('year');
    $salesPerson = $this->request->getGet('sales_person');

    $leadModel = new LeadModel();

    $data = [
        'title'        => 'All Leads',
        'leads'        => $leadModel->filterLeads($location, $year, $salesPerson),
        'filters'      => [
            'location'     => $location,
            'year'         => $year,
            'sales_person' => $salesPerson
        ],
        'locations'    => $leadModel->getLocations(),
        'years'        => $leadModel->getYears(),
        'salesPersons' => $leadModel->getSalesPersons(),
    ];

    return view('leads/index', $data);
}

public function createOnlineLead(){

    
}

public function createQuicklead($companyId = null)
{
    $leadModel = new \App\Models\LeadModel();
    $contactModel = new ContactModel();
    $db = \Config\Database::connect();

    // Get first contact for this company
    $contact = $contactModel
                    ->select('contact_id')
                    ->where('company_id', $companyId)
                    ->first();

    // Prepare Lead Data
    $leadData = [
        'company_id'      => $companyId,
    'contact_id'      => $contact ? $contact['contact_id'] : null, // safe check

    // Dummy values below
    'exhibition_year' => '2026',
    'fascia'          => 'Standard Fascia',
    'sales_person'    => 'Admin',
    'exhibitor'       => 'Yes',
    'booking_form'    => 'Received',
    'status'          => 'New',
    'payment_status'  => 'Pending',

    'created_at'      => date('Y-m-d H:i:s')
];


    // 2. Insert Lead and get the ID
    $leadId = $leadModel->insert($leadData);

    if ($leadId) {
        $locationBuilder = $db->table('lead_locations');
        $locations = [
            'Chennai',
            'Bengaluru',
            'Pune',
            'Hyderabad',
            'Kolkata',
            'Ahmedabad'
        ];

        // 2. Pick a random location
        $randomLocation = $locations[array_rand($locations)];


        // Insert one dummy location for quick lead
        $locationBuilder->insert([
            'lead_id'        => $leadId,
            'location'       => $randomLocation,       // dummy location name
            'stall_location' => 'A1',           // dummy stall
            'size'           => '3',          // dummy size
            'price'          => '',           // dummy price
            'grand_total'    => '',           // can add GST logic later
        ]);
    }


return redirect()->to(base_url("booking/company/$leadId"));
}


public function createLead()
{
    $leadModel = new \App\Models\LeadModel();
    $db = \Config\Database::connect();

    // 1. Prepare Main Lead Data
    $leadData = [
        'company_id'      => $this->request->getPost('company_id'),
        'exhibition_year' => $this->request->getPost('exhibition_year'),
        'fascia'          => $this->request->getPost('fascia'),
        'sales_person'    => $this->request->getPost('sales_person'),
        'exhibitor'       => $this->request->getPost('exhibitor'),
        'booking_form'    => $this->request->getPost('booking_form'),
        'status'          => $this->request->getPost('status'),
        'payment_status'  => $this->request->getPost('payment_status'),
        'created_at'      => date('Y-m-d H:i:s')
    ];

    // 2. Insert Lead and get the ID
    $leadId = $leadModel->insert($leadData);

    if ($leadId) {
        // 3. Capture multiple locations from the form
        $locations = $this->request->getPost('locations'); // Expects array from UI
        $locationBuilder = $db->table('lead_locations');

        foreach ($locations as $loc) {
            $locationBuilder->insert([
                'lead_id'        => $leadId,
                'location'       => $loc['name'],
                'stall_location' => $loc['stall'],
                'size'           => $loc['size'],
                'price'          => $loc['price'],
                'grand_total'    => $loc['price'], // Add GST logic here if needed
            ]);
        }
    }

return redirect()->to(base_url("booking/company/$leadId"));
}
// Details of single company
// Details of single company via Lead ID
public function details($leadID = null)
{
    if (!$leadID) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $companyModel  = new CompanyModel();
    $contactModel  = new ContactModel();
    $updationModel = new UpdationModel();
    $leadModel     = new LeadModel();
    $sourceModel   = new \App\Models\SourceModel();
    $discussionModel = new DiscussionModel();

    // Get company_id from lead_id
    $leadRow = $leadModel->getCompanyIdByLeadId($leadID);

    if (!$leadRow || empty($leadRow['company_id'])) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');
    }

    $companyId = $leadRow['company_id'];

    // Get full company data
    $company = $companyModel->getByCompanyId($companyId);

    if (!$company) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Company not found');
    }

    // Prepare data
    $data = [
        'company'  => $company,
        'contacts' => $contactModel->getByCompanyId($companyId),
        'updates'  => $updationModel->getByCompanyId($companyId),
        'leads'    => [$leadModel->getByLeadId($leadID)], // wrap as array for view
         'sources' => $sourceModel->where('company_id', $companyId)->findAll(),
        'discussions'=> $discussionModel->getByLeadId($leadID)  // <- fetch discussions for this lead
    ];

    return view('leads/details', $data);
}


public function getByCompanyIdFromLeadId($leadID = null)
{
    if (!$leadID) {
        return null;
    }

    return $this->select('company_id')
                ->where('lead_id', $leadID)
                ->first();
}


public function add()
{
    $discussionModel = new \App\Models\DiscussionModel();
    $post = $this->request->getPost();

    $discussionModel->insert([
        'lead_id' => $post['lead_id'],
        'action' => $post['action'],
        'message' => $post['message'],
        'discussion_date' => date('Y-m-d H:i:s')
    ]);

    return redirect()->back()->with('status', '✅ Discussion added successfully');
}


public function clearLeads()
{
    // Connect to DB service
    $db = \Config\Database::connect();

    // Wrap in a transaction
    $db->transStart();

    // Disable foreign key checks temporarily
    $db->query('SET FOREIGN_KEY_CHECKS=0');

    // Truncate child table first
    $db->table('lead_locations')->truncate();

    // Then truncate parent table
    $db->table('leads')->truncate();

    // Re-enable foreign key checks
    $db->query('SET FOREIGN_KEY_CHECKS=1');

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('status', '❌ Failed to clear leads.');
    }

    return redirect()->to(base_url('company'));
}

public function addRandomLead()
{
    $db = \Config\Database::connect();
    $leadModel = new \App\Models\LeadModel();

    $company = $db->table('company_data')->orderBy('RAND()')->get()->getRowArray();
    if (!$company) return redirect()->back()->with('status', 'No company found.');

    // 1. Insert Main Lead
    $leadId = $leadModel->insert([
        'company_id'      => $company['company_id'],
        'exhibition_year' => rand(2020, 2026),
        'fascia'          => 'Fascia ' . rand(1, 100),
        'sales_person'    => $company['sales_person'] ?? 'Random Sales',
        'exhibitor'       => 'Exhibitor ' . rand(1, 999),
        'status'          => 'draft',
        'created_at'      => date('Y-m-d H:i:s'),
    ]);

    // 2. Insert 2 Random Locations for this lead
    $locBuilder = $db->table('lead_locations');
    for ($i = 0; $i < 2; $i++) {
        $locBuilder->insert([
            'lead_id'        => $leadId,
            'location'       => ['Mumbai', 'Delhi', 'Bangalore'][rand(0, 2)],
            'stall_location' => 'Stall ' . chr(rand(65, 90)) . rand(1, 50),
            'size'           => rand(9, 36) . 'sqm',
            'price'          => rand(5000, 20000),
            'grand_total'    => rand(5000, 20000)
        ]);
    }

    return redirect()->back()->with('status', '✅ Lead created with 2 locations.');
}



}
