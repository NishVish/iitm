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
// POST: Process payment
public function processPayment()
{
    // $post = $this->request->getPost();

    // // Validate required fields
    // if (empty($post['lead_id']) || empty($post['company_id']) || empty($post['price'])) {
    //     return redirect()->back()->with('error', 'Missing required information.');
    // }

    // // Calculate totals
    // $price = (float)$post['price'];
    // $gst = $price * 0.18; // 18% GST
    // $grandTotal = $price + $gst;

    // Prepare data for DB / view
    // $data = [
    //     'lead_id' => $post['lead_id'],         // pass lead id
    //     'company_id' => $post['company_id'],
    //     'price' => $price,
    //     'gst' => $gst,
    //     'grand_total' => $grandTotal
    // ];
// Random test data
// Random test data
$price = rand(50000, 200000);                // Random price between ₹50,000 - ₹2,00,000
$discount = rand(0, 20000);                  // Random discount up to ₹20,000
$priceAfterDiscount = max($price - $discount, 0);
$gst = round($priceAfterDiscount * 0.18, 2); // 18% GST
$grandTotal = round($priceAfterDiscount + $gst, 2);

// Prepare data for DB / view (no POST at all)
$data = [
    'lead_id' => 'LEAD' . rand(1000, 9999),       // random lead_id
    'company_id' => 'COMP' . rand(100, 999),      // random company_id
    'price' => $priceAfterDiscount,
    'discount' => $discount,
    'gst' => $gst,
    'grand_total' => $grandTotal
];

// Make $lead available for header3.php
$lead = [
    'lead_id' => $data['lead_id'],
    'company_id' => $data['company_id']
];

// Pass all info to payment view
return view('booking/payment', array_merge($data, ['lead' => $lead]));

// Example output to verify
// print_r($data);

    // Optionally, save payment info to DB here
    // $this->paymentModel->insert($data);

    // Pass all info to payment page
    return view('booking/payment', $data);
}


public function exhibitor_bookinginstructions()
{
    // You can pass any default data to the view if needed

    // echo "hello";
    // exit;
    // Load the form view
    return view('booking/exhibitor/instructions');
}
public function stallinfo()
{
    // You can pass any default data to the view if needed

    // echo "hello";
    // exit;
    // Load the form view
    return view('booking/exhibitor/stallinfo');
}    
// $routes->get('exhibitor_booking/details', 'Booking::exhibitor_details');

public function exhibitor_details()
{
    // You can pass any default data to the view if needed

    // echo "hello";
    // exit;
    // Load the form view
    return view('booking/exhibitor/exhibitor_form');
}

}
