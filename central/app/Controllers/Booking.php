<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\LeadModel;
use App\Models\ExhibitionModel;
use CodeIgniter\Controller;

class Booking extends BaseController
{
    protected $companyModel;
    protected $contactModel;
    protected $exhibitionModel;
    protected $leadModel;

    public function __construct()
    {
        $this->companyModel    = new CompanyModel();
        $this->contactModel    = new ContactModel();
        $this->exhibitionModel = new ExhibitionModel();
        $this->leadModel       = new LeadModel();
        helper(['form', 'url']);
    }

    // STEP 1: Instructions
    public function instructions($leadId = null)
    {
        if (!$leadId) {
            return redirect()->to('/booking')->with('error','Lead ID missing');
        }

        // Fetch lead
        $lead = $this->leadModel->getByLeadId($leadId);
        if (!$lead) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lead not found');
        }

        // Fetch company via lead
        $company = $this->companyModel->where('company_id', $lead['company_id'])->first();

        $data = [
            'lead' => $lead,
            'company' => $company
        ];

        return view('booking/instructions', $data);
    }

    // STEP 2: Company Details via Lead
    public function company($leadId)
    {
        $lead = $this->leadModel->getByLeadId($leadId);
        if (!$lead) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lead not found');
        }

        $company = $this->companyModel->where('company_id', $lead['company_id'])->first();
        $contacts = $this->contactModel->where('company_id', $lead['company_id'])->findAll();

        $data = [
            'lead' => $lead,
            'company' => $company,
            'contacts' => $contacts
        ];

        return view('booking/company', $data);
    }

    // STEP 3: Exhibition Details + Calculation + Payment
    public function booking_details($leadId = null)
    {
        if (!$leadId) {
            return redirect()->to('/booking/instructions/'.$leadId)
                             ->with('error','Select a lead');
        }

        // Fetch lead
        $lead = $this->leadModel->getByLeadId($leadId);
        if (!$lead) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lead not found');
        }

        // Fetch company & contacts via lead
        $company = $this->companyModel->where('company_id', $lead['company_id'])->first();
        $contacts = $this->contactModel->getByCompanyId($lead['company_id']);
        // $exhibitions = $this->exhibitionModel->findAll();

        $data = [
            'lead' => $lead,
            'company' => $company,
            'contacts' => $contacts,
            // 'exhibitions' => $exhibitions
        ];

        return view('booking/booking_details', $data);
    }

    




    public function processPayment()
{
    $post = $this->request->getPost();

    if (!$post) {
        return redirect()->back()->with('error', 'Invalid Request');
    }

  $leadId = $post['lead_id'];
$companyId = $post['company_id'];
$location = $post['locations'][0] ?? null; // First location, or null if not set
$size = $post['sizes'][0] ?? null;         // First size, or null if not set
$price = $post['price'][0] ?? null;

// Calculate
$gst = round($price * 0.18, 2);
$grandTotal = round($price + $gst, 2);

// Debug output and stop
// echo "<pre>";
// echo "leadId: "; var_dump($leadId);
// echo "companyId: "; var_dump($companyId);
// echo "location: "; var_dump($location);
// echo "size: "; var_dump($size);
// echo "price: "; var_dump($price);
// echo "gst: "; var_dump($gst);
// echo "grandTotal: "; var_dump($grandTotal);
// echo "</pre>";
// exit;


    // Update lead in database
    $db = \Config\Database::connect();

    $builder = $db->table('leads');

$updated = $builder->where('lead_id', $leadId)->update([
    'location' => $location ?: '',
    'size' => $size ?: '',
    'price' => $price ?: 0,
    'gst_amount' => $gst ?: 0,
    'grand_total' => $grandTotal ?: 0,
    'status' => 'payment_pending'
]);

if (!$updated) {
    return redirect()->back()->with('error', 'Failed to update lead. Please check lead ID.');
}


$data = [
    'lead_id'     => $leadId,
    'company_id'  => $companyId,
    'price'       => $price,
    'gst'         => $gst,
    'grand_total' => $grandTotal, // Make sure the key matches the view
];

    return view('booking/payment', $data);
}






public function summary($leadId)
{
    $db = \Config\Database::connect();

    // Get lead details
    $lead = $db->table('leads')
        ->where('lead_id', $leadId)
        ->get()
        ->getRowArray();

    if (!$lead) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Lead not found");
    }

    // Get company details
    $company = $db->table('company_data')
        ->where('company_id', $lead['company_id'])
        ->get()
        ->getRowArray();

    // Get payments
    $payments = $db->table('payments')
        ->where('lead_id', $leadId)
        ->get()
        ->getResultArray();

    $data = [
        'lead' => $lead,
        'company' => $company,
        'payments' => $payments
    ];

    return view('booking/summary', $data);
}


    public function public_view(){
    return view('booking/view');
    }

public function show_booking_details()
    {
        $leadId = $this->request->getPost('lead_id');

        if (!$leadId) {
            return redirect()->back()->with('status', '⚠ Please enter a Lead / Booking ID.');
        }

        // Fetch the lead
        $lead = $this->leadModel->where('lead_id', $leadId)->first();
        if (!$lead) {
            return redirect()->back()->with('status', '⚠ Lead / Booking not found.');
        }

        $companyId = $lead['company_id'];

        // Fetch company info
        $company = $this->companyModel->where('company_id', $companyId)->first();

        // Fetch contacts for company
        $contacts = $this->contactModel->where('company_id', $companyId)->findAll();

        // For each contact, fetch emails and mobiles
        foreach ($contacts as &$contact) {
            $contact['emails']  = $this->contactModel->getEmails($contact['contact_id']);
            $contact['mobiles'] = $this->contactModel->getMobiles($contact['contact_id']);
        }

        // // Fetch discussions
        // $discussions = $this->discussionModel->where('lead_id', $leadId)->findAll();

        // // Fetch invoices
        // $invoices = $this->invoiceModel->where('lead_id', $leadId)->findAll();

        // // Fetch sources
        // $sources = $this->sourceModel->where('company_id', $companyId)->findAll();

        // // Fetch event / exhibition details
        // $event = $this->exhibitionModel->where('event_id', $lead['exhibition_year'])->first();

        $data = [
            'lead'        => $lead,
            'company'     => $company,
            'contacts'    => $contacts,
            // 'discussions' => $discussions,
            // 'invoices'    => $invoices,
            // 'sources'     => $sources,
            // 'event'       => $event,
        ];

        return view('show_booking_details', $data);
    }
}
