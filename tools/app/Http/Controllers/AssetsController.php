<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function index()
    {
        // Data array
        $data = [
            'logo' => 'https://iitmindia.com/assets/iitm3.png',
            'logo2' => 'https://iitmindia.com/assets/iitm3.png',
            'creative1' => 'https://iitmindia.com/assets/creatives/1.jpg',
        ];

        // Return view with data
        return view('assets', $data);
    }
}