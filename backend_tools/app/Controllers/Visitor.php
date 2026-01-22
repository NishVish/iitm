<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TradeVisitorModel;

class Visitor extends Controller
{
    public function index()
    {
        $model = new TradeVisitorModel();

        // Get all visitor records
        $data['visitors'] = $model->findAll();

        // Load the view
        echo view('visitor', $data);
    }
}
