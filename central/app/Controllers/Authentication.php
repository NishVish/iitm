<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Authentication extends BaseController
{


public function index()
    {
        return view("login");
    }

public function login()
{
    $request = service('request');

    // Get POST data safely
    $pin = $request->getPost('pin');

    if ($pin === 'sphere') {
        // Start session
        $session = session();
        $session->set('authenticated', true);

        // Redirect to welcome route
        return redirect()->route('welcome');
    } else {
        // Set flashdata for error message
        $session = session();
        $session->setFlashdata('error', 'Invalid PIN!');

        // Return login view
        return view('login');
    }
}

}