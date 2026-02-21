<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Webscraper extends BaseController
{


public function index()
    {
        return view('tools/webscraper');
    }

public function scrape()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://example.com");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

}