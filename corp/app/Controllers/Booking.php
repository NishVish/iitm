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
// STEP 2: Company Details via Lead
public function company($leadId)
{
    // 1. Get the lead
    $lead = $this->leadModel->getByLeadId($leadId);
    if (!$lead) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Lead not found');
    }

    // 2. Get company info
    $company = $this->companyModel
                    ->where('company_id', $lead['company_id'])
                    ->first();

    // 3. Get all contacts for the company
    $allcontact = $this->contactModel
                       ->getByCompanyId($lead['company_id']);

    $primaryContact = null;

    // 4. If lead has contact_id, move it to first index
    if (!empty($lead['contact_id']) && !empty($allcontact)) {

        foreach ($allcontact as $key => $contact) {

            if ($contact['contact_id'] == $lead['contact_id']) {

                // Store matched contact
                $primaryContact = $contact;

                // Remove from current position
                unset($allcontact[$key]);

                // Add to beginning
                array_unshift($allcontact, $primaryContact);

                break;
            }
        }

        // Re-index array
        $allcontact = array_values($allcontact);
    }

    // 5. Pass to view
    $data = [
        'lead'            => $lead,
        'company'         => $company,
        'primaryContact'  => $primaryContact,
        'allcontact'      => $allcontact
    ];

    return view('booking/company', $data);
}




public function update($leadId)
{
    $leadModel    = new \App\Models\LeadModel();
    $companyModel = new \App\Models\CompanyModel();
    $contactModel = new \App\Models\ContactModel();
    $db           = \Config\Database::connect();

    $post = $this->request->getPost();

    // 1. Get lead
    $lead = $leadModel->find($leadId);
    if (!$lead) {
        return redirect()->back()->with('error', 'Lead not found.');
    }

    $companyId = $lead['company_id'];

    // 2. Update company
    $companyData = [
        'company_name' => $post['company_name'] ?? null,
        'category'     => $post['category'] ?? null,
        'city'         => $post['city'] ?? null,
        'state'        => $post['state'] ?? null,
        'phone'        => $post['phone'] ?? null,
        'gst_number'   => $post['gst_number'] ?? null,
        'fascia'       => $post['fascia'] ?? null,
    ];
    $companyModel->update($companyId, $companyData);
// echo '<pre>';
// var_dump($companyData);

if (!empty($post['contact_id'])) {

    $contactId = $post['contact_id'];

    // Update main contact
    $contactData = [
        'name'        => $post['name'] ?? null,
        'designation' => $post['designation'] ?? null,
    ];

    // var_dump($contactData); // debug
    // exit;

    $contactModel->update($contactId, $contactData);

    // Update mobiles
    if (!empty($post['mobile'])) {

        $mobiles = array_map('trim', explode(',', $post['mobile']));

        $db->table('contact_mobile')
           ->where('contact_id', $contactId)
           ->delete();

        foreach ($mobiles as $m) {
            if ($m !== '') {
                $db->table('contact_mobile')->insert([
                    'contact_id' => $contactId,
                    'mobile'     => $m
                ]);
            }
        }
    }

    // Update emails
    if (!empty($post['email'])) {

        $emails = array_map('trim', explode(',', $post['email']));

        $db->table('contact_email')
           ->where('contact_id', $contactId)
           ->delete();

        foreach ($emails as $e) {
            if ($e !== '') {
                $db->table('contact_email')->insert([
                    'contact_id' => $contactId,
                    'email'      => $e
                ]);
            }
        }
    }

    // Update lead primary contact
    $leadModel->update($leadId, [
        'contact_id' => $contactId
    ]);
}


    // 5. Redirect back with success
    return redirect()->to(site_url('booking/company/' . $leadId))
                     ->with('success', 'Company and primary contact updated successfully!');
}














    // STEP 3: Exhibition Details + Calculation + Payment
 public function booking_details($leadId = null)
{
    if (!$leadId) {
        return redirect()->back()->with('error','Invalid Lead');
    }

    $lead = $this->leadModel->find($leadId);

    if (!$lead) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Lead not found');
    }

    $company = $this->companyModel
                    ->where('company_id', $lead['company_id'])
                    ->first();

    $contacts = $this->contactModel
                     ->where('company_id', $lead['company_id'])
                     ->findAll();

    // 🔥 Fetch saved stall selections
    $db = \Config\Database::connect();
    $savedLocations = $db->table('lead_locations')
                         ->where('lead_id', $leadId)
                         ->get()
                         ->getResultArray();
$baseTotal = 0;

    return view('booking/booking_details', [
        'lead' => $lead,
        'company' => $company,
        'contacts' => $contacts,
        'savedLocations' => $savedLocations
    ]);
}

    
public function savebookingdetails($leadId = null)
{
    $post = $this->request->getPost();

    if (!$post && !$leadId) {
        return redirect()->back()->with('error', 'Invalid Request');
    }

    // Optional: if lead_id not in POST, take it from URI
    $leadId = $leadId ?? $post['lead_id'];
    $companyId = $post['company_id'] ?? null;
    $locations = $post['locations'] ?? [];
    $sizes = $post['sizes'] ?? [];

    $rates = [
        "Chennai"   => 32000,
        "Bengaluru" => 35000,
        "Pune"      => 32000,
        "Hyderabad" => 32000,
        "Kolkata"   => 32000,
        "Ahmedabad" => 32000
    ];

    $db = \Config\Database::connect();
    $locationTable = $db->table('lead_locations');

    $baseTotal = 0;

    // Fetch existing locations for this lead
    $existing = $locationTable->where('lead_id', $leadId)->get()->getResultArray();
    $existingMap = [];
    foreach ($existing as $row) {
        $existingMap[$row['location']] = $row['location_id'];
    }

    foreach ($locations as $index => $loc) {
        if (!isset($rates[$loc])) continue;

        $size  = (int)$sizes[$index];
        $price = $rates[$loc] * $size;
        $gst   = round($price * 0.18, 2);
        $grand = round($price + $gst, 2);

        $baseTotal += $price;

        if (isset($existingMap[$loc])) {
            // Update existing row
            $locationTable->where('location_id', $existingMap[$loc])
                          ->update([
                              'size'           => $size,
                              'price'          => $price,
                              'gst_amount'     => $gst,
                              'grand_total'    => $grand,
                              'discount_amount'=> 0
                          ]);
        } else {
            // Insert new location
            $locationTable->insert([
                'lead_id'        => $leadId,
                'location'       => $loc,
                'size'           => $size,
                'price'          => $price,
                'gst_amount'     => $gst,
                'discount_amount'=> 0,
                'grand_total'    => $grand
            ]);
        }
    }

    // Update totals and status
    $totalGst   = round($baseTotal * 0.18, 2);
    $finalGrand = round($baseTotal + $totalGst, 2);

    $db->table('leads')
       ->where('lead_id', $leadId)
       ->update([
           'status'         => 'payment_pending',
           'payment_status' => 'pending'
       ]);

    return $this->summary($leadId);
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

    // Get payments made for this lead
    $payments = $db->table('payments')
        ->where('lead_id', $leadId)
        ->get()
        ->getResultArray();

    // Get selected locations for this lead
    $locations = $db->table('lead_locations')
        ->where('lead_id', $leadId)
        ->get()
        ->getResultArray();

    // Calculate totals if needed
    $totalPrice = 0;
    $totalGst   = 0;
    $grandTotal = 0;

    foreach ($locations as $loc) {
        $totalPrice += $loc['price'];
        $totalGst   += $loc['gst_amount'];
        $grandTotal += $loc['grand_total'];
    }

    $data = [
        'lead'        => $lead,
        'company'     => $company,
        'payments'    => $payments,
        'locations'   => $locations,
        'totalPrice'  => $totalPrice,
        'totalGst'    => $totalGst,
        'grandTotal'  => $grandTotal
    ];

    return view('booking/summary', $data);
}






/////////////////////////////////////////////////////////////////////////////////////////////////////////

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
