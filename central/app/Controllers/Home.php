<?php

namespace App\Controllers;
use App\Models\DashboardModel;


class Home extends BaseController
{


    // public function index()
    // {
    //     return view("home/index");
    // }

    public function index()
{
    // Load model
    $dashboardModel = new \App\Models\DashboardModel();

    // Get stats from model
    $databasedetails = $dashboardModel->get_count_by_database();                  
    $databasedetailsgroupbysource = $dashboardModel->get_count_by_database_and_source(); 

    // Example: get current segment (from URI or default value)
    $currentSegment = $this->request->getGet('ticket') ?? ''; // You can adjust based on your logic

    // Pass all data to the view
    return view('home/index', [
        'databasedetails' => $databasedetails,
        'databasedetailsgroupbysource' => $databasedetailsgroupbysource,
        'currentSegment' => $currentSegment // <-- Pass this to the view
    ]);
}

    //     public function home(): string
    // {
    //     return view('home/index');
    // }
}
