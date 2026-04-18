<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Authentication extends BaseController
{
    public function index()
    {
        // echo "hello";
        // exit;
        return view("login");
    }

    public function login()
    {
    }
    public function backendlogin()
    {
        $request = service('request');
        $session = session();

        // Check if it's a GET request, then return the login view
        if ($request->getMethod() === 'get') {
            return view('backend/login');
        }

        // Check if it's a POST request for login
        if ($request->getMethod() === 'post') {
            // Retrieve the PIN from the POST request
            $pin = $request->getPost('pin');

            // Fetch user by PIN from the database
            $usersModel = new UserModel();
            $user = $usersModel->getByPin($pin);

            // Get the database name (for session purposes)
            $db = \Config\Database::connect();
            $query = $db->query("SELECT DATABASE() as db");
            $row = $query->getRow();
            $databasename = $row->db;

            // Check if the PIN is for the superuser (hardcoded admin check)
            if ($pin === 'superx' && !$user) {
                // Super user logic
                $sessionData = [
                    'authenticated' => true,
                    'user_id' => 0,
                    'employee_id' => 'SUPER',
                    'name' => 'Super User',
                    'designation' => 'Admin',
                    'phone' => 'N/A',
                    'address' => 'N/A',
                    'email' => 'super@dummy.com',
                    'category' => 'Admin',
                    'department' => 'Admin',
                    'doj' => date('Y-m-d'),
                    'uan_no' => 'N/A',
                    'fathers_name' => 'N/A',
                    'aadhaar_card' => 'N/A',
                    'pan_card' => 'N/A',
                    'bank_account_number' => 'N/A',
                    'ifsc_code' => 'N/A',
                    'user_type' => 'superuser',
                    'server' => $databasename
                ];
                $session->set($sessionData);
                return redirect()->route('home');
            }

            // If a user is found, set the session with their data
            if ($user) {
                // Assuming you have hashed passwords, verify PIN here if needed
                $sessionData = [
                    'authenticated' => true,
                    'user_id' => $user['id'],
                    'employee_id' => $user['employee_id'],
                    'name' => $user['name'],
                    'designation' => $user['designation'],
                    'phone' => $user['phone'],
                    'address' => $user['address'],
                    'email' => $user['email'],
                    'category' => $user['category'],
                    'department' => $user['department'],
                    'doj' => $user['doj'],
                    'uan_no' => $user['uan_no'],
                    'fathers_name' => $user['fathers_name'],
                    'aadhaar_card' => $user['aadhaar_card'],
                    'pan_card' => $user['pan_card'],
                    'bank_account_number' => $user['bank_account_number'],
                    'ifsc_code' => $user['ifsc_code'],
                    'user_type' => $user['user_type'],
                    'journal' => $user['journal'] ?? '',
                    'server' => $databasename
                ];
                $session->set($sessionData);
                return redirect()->route('home');
            } else {
                // Flash error message if no user found
                $session->setFlashdata('error', 'Invalid PIN!');
                return redirect()->to('/backendlogin');
            }
        }
    }

    // public function logout()
    // {
    //     session()->destroy();
    //     return redirect()->to('/login');
    // }

    public function logout()
    {
        session()->destroy();

        // Redirect to login page
        return redirect()->route('/');
    }

}

