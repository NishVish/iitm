<?php

namespace App\Controllers;

use App\Models\LeadModel;

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


}
