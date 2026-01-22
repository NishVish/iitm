<?php

namespace App\Controllers;

use App\Models\Database_CompanydataModel;
use CodeIgniter\Controller;

class Database extends Controller
{
    public function index()
    {
        $model = new Database_CompanydataModel();
        $data = $model->findAll(10);

        return $this->response->setJSON($data);
    }

public function summaryByState()
{
  $model = new \App\Models\Database_CompanydataModel();
    
    $builder = $model->builder(); // Get query builder from model

    $builder->select("
        state, 
        COUNT(state) AS total_count_state,
        SUM(CASE WHEN category = 'TA' THEN 1 ELSE 0 END) AS travel_agents,
        SUM(CASE WHEN category IN ('Hotel', 'HT') THEN 1 ELSE 0 END) AS hotels,
        SUM(CASE WHEN category = 'Miscellaneous' THEN 1 ELSE 0 END) AS miscellaneous,
        SUM(CASE WHEN category = 'General' THEN 1 ELSE 0 END) AS general
    ")
    ->groupBy('state')
    ->orderBy('state');

    $query = $builder->get();
    $data = $query->getResultArray();

    return $this->response->setJSON($data);
}







}
