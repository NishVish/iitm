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

public function downloadapp()
{
    $file = WRITEPATH . 'uploads/app.apk';

    return $this->response->download($file, null);
}


public function openqr($type, $value)
{
    // Just pass the raw values to the view
    $value = str_replace('-', '/', $value);
    if ($type === 'link') {
        $value = str_replace('-', '/', $value);
    }elseif ($type == 'text')
     
    {
        # code...
    }

    $data = [
        'type' => $type,
        'value' => $value
    ];
    
print_r($data);
    return view('open/qr', $data);
}


}
