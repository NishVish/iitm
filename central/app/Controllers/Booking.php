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
        $post = $this->request->getPost();

        // Calculate totals
        $price = (float)$post['price'];
        $gst = $price * 0.18; // 18% GST
        $grandTotal = $price + $gst;

        // Save to DB (example)
        $data = [
            'lead_id' => $post['lead_id'],
            'company_id' => $post['company_id'],
            'price' => $price,
            'gst' => $gst,
            'grand_total' => $grandTotal
        ];

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
