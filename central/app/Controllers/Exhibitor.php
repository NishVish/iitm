<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\ExhibitionModel;
use CodeIgniter\Controller;

class Exhibitor extends BaseController
{
    protected $companyModel;
    protected $contactModel;
    protected $exhibitionModel;

    public function __construct()
    {
        $this->companyModel    = new CompanyModel();
        $this->contactModel    = new ContactModel();
        $this->exhibitionModel = new ExhibitionModel();
        helper(['form', 'url']);
    }

    // STEP 1: Instructions
public function instructions($companyId = null)
{
    $data = [];

    if ($companyId) {
        $data['company'] = $this->companyModel->where('company_id', $companyId)->first();
    }

    return view('exhibitor/instructions', $data);
}
public function company($companyId = null)
{
    if (!$companyId) {
        return redirect()->to('/exhibitor/instructions')->with('error','Select a company');
    }

    // Fetch company & contacts
    $company  = $this->companyModel->where('company_id', $companyId)->first();
    $contacts = $this->contactModel->where('company_id', $companyId)->findAll();

    if (!$company) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Company not found');
    }

    $data = [
        'company'  => $company,
        'contacts' => $contacts
    ];

    return view('exhibitor/company', $data);
}


    // STEP 3: Exhibition Details + Calculation + Payment
    public function exhibition($companyId = null)
    {
        if (!$companyId) {
            return redirect()->to('/exhibitor/instructions')->with('error','Select a company');
        }
        $contactModel  = new ContactModel();
        $company = $this->companyModel->where('company_id',$companyId)->first();
        $contacts = $this->contactModel->where('company_id',$companyId)->findAll();
        $exhibitions = $this->exhibitionModel->findAll(); // list of possible exhibitions

        $data = [
            'company' => $company,
            'contacts' => $contactModel->getByCompanyId($companyId),
            'exhibitions' => $exhibitions
        ];

        return view('exhibitor/exhibition', $data);
    }

    // POST: Process payment
    public function processPayment()
    {
        $post = $this->request->getPost();

        // Calculate total
        $price = (float)$post['price'];
        $gst = $price * 0.18; // 18% GST
        $grandTotal = $price + $gst;

        // Normally: Save to DB here (leads / payments)

        $data = [
            'company_id' => $post['company_id'],
            'price' => $price,
            'gst' => $gst,
            'grand_total' => $grandTotal
        ];

        return view('exhibitor/payment', $data);
    }
}
