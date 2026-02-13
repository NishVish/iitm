<?php

namespace App\Controllers;

use App\Models\LeadModel;
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

public function createLead()
{
    $leadModel = new \App\Models\LeadModel();

    $data = [
        'company_id'       => $this->request->getPost('company_id'),
        'exhibition_year'  => $this->request->getPost('exhibition_year'),
        'location'         => $this->request->getPost('location'),
        'size'             => $this->request->getPost('size'),
        'fascia'           => $this->request->getPost('fascia'),
        'stall_location'   => $this->request->getPost('stall_location'),
        'price'            => $this->request->getPost('price'),
        'sales_person'     => $this->request->getPost('sales_person'),
        'exhibitor'        => $this->request->getPost('exhibitor'),
        'booking_form'     => $this->request->getPost('booking_form'),
        'status'           => $this->request->getPost('status'),
        'payment_status'   => $this->request->getPost('payment_status'),
        'created_at'       => date('Y-m-d H:i:s')
    ];

    $leadModel->insert($data);

    // Redirect back to the company details page
    return redirect()->back()->with('success', 'Lead created successfully!');
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
    $leadModel = new \App\Models\LeadModel();

    // Truncate the leads table
    $leadModel->truncate();

    // Redirect back with a flash message
    return redirect()->back()->with('status', '✅ All leads have been cleared successfully.');
}

public function addRandomLead()
{
    $db = \Config\Database::connect();

    // 1. Pick a random company_id
    $company = $db->table('company_data')
                  ->orderBy('RAND()')
                  ->get()
                  ->getRowArray();

    if (!$company) {
        return redirect()->back()->with('status', '⚠ No company found to add lead.');
    }

    $companyId = $company['company_id'];
    $salesPerson = $company['sales_person'] ?? 'Random Sales';

    // 2. Generate random lead details
    $locations = ['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Kolkata'];
    $sizes     = ['Small', 'Medium', 'Large'];
    $statuses  = ['draft', 'confirmed', 'cancelled'];
    $payments  = ['pending', 'paid', 'refunded'];

    $data = [
        'company_id'       => $companyId,
        'exhibition_year'  => rand(2020, 2026),
        'location'         => $locations[array_rand($locations)],
        'size'             => $sizes[array_rand($sizes)],
        'fascia'           => 'Fascia ' . rand(1, 100),
        'stall_location'   => 'Stall ' . chr(rand(65, 90)) . rand(1, 50),
        'price'            => rand(1000, 50000),
        'gst_amount'       => 0,
        'grand_total'      => 0,
        'discount_amount'  => 0,
        'sales_person'     => $salesPerson,
        'exhibitor'        => 'Exhibitor ' . rand(1, 999),
        'booking_form'     => 'Form ' . rand(1, 999),
        'status'           => $statuses[array_rand($statuses)],
        'payment_status'   => $payments[array_rand($payments)],
        'created_at'       => date('Y-m-d H:i:s'),
        'updated_at'       => date('Y-m-d H:i:s'),
    ];

    // 3. Insert into leads table
    $leadModel = new \App\Models\LeadModel();
    $leadModel->insert($data);

    return redirect()->back()->with('status', '✅ Random lead added for company: ' . $company['company_name']);
}




}
