<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Operations extends BaseController
{
    public function index()
    {
        // add vendor
        // eventid 
        // category
        // name 
        // mobile 
        

        return view('search/results', $data);
    }
}
