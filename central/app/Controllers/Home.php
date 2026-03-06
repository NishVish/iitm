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
    $databasedetails = $dashboardModel->get_count_by_database();                  // Counts by database_name
    $databasedetailsgroupbysource = $dashboardModel->get_count_by_database_and_source(); // Counts by database_name + source

    // Pass both datasets to the view
    return view('home/index', [
        'databasedetails' => $databasedetails,
        'databasedetailsgroupbysource' => $databasedetailsgroupbysource
    ]);
}


    //     public function home(): string
    // {
    //     return view('home/index');
    // }
}
