<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Authentication extends BaseController
{

    public function login()
    {
        // Get POST data safely
        $pin = isset($_POST['pin']) ? $_POST['pin'] : '';

        // Check if pin matches
        if ($pin === 'sanjaydon') {

        return view('home/index');
            // // Start session if not already started
            // if (session_status() === PHP_SESSION_NONE) {
            //     session_start();
            // }

            // // You can set a session variable if needed
            // $_SESSION['authenticated'] = true;

            // // Redirect or call main function
            // $this->main();
        } else {
            // Invalid pin
            echo "Invalid PIN!";
        }
    }

}