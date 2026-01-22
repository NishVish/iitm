<?php
namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\LeadModel;

class Dashboard extends BaseController
{
    protected $companyModel;
    protected $leadModel;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->leadModel = new LeadModel();
    }

public function index()
{
    // Counts by state
    $count_by_state = $this->companyModel->getCountsByStateCategory();

    // Calculate totals
    $total_companies = 0;
    $total_travel_agents = 0;
    $total_hotels = 0;
    foreach($count_by_state as $row){
        $total_companies += $row->total_count;
        $total_travel_agents += $row->travel_agents;
        $total_hotels += $row->hotels;
    }

    $data = [
        // 'total_companies' => $total_companies,
        // 'total_leads' => $this->leadModel->getTotalLeads(),
        // 'payment_summary' => $this->leadModel->getPaymentSummary(),
        'companies' => $this->companyModel->getCompanies(),
        'count_by_state' => $count_by_state,
        'totals' => [
            'total_companies' => $total_companies,
            'total_travel_agents' => $total_travel_agents,
            'total_hotels' => $total_hotels
        ]
    ];

    return view('dashboard/index', $data);
}


    // AJAX company search
public function search()
{
    $search = $this->request->getPost('search');
    $companies = $this->companyModel->getCompanies($search);
    return $this->response->setJSON($companies);
}

}
