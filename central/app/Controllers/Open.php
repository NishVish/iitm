<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Open extends BaseController
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

    public function openqr($url)
{
    $data['url'] = $url; // pass the URL to the view
    return view('open/qr', $data);
}


}
