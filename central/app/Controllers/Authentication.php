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
        $request = service('request');
        $session = session();

        $pin = isset($_POST['pin']) ? $_POST['pin'] : '';

        // Get email and password from POST
        // $email = $request->getPost('pin');
$password = $request->getPost('pin');

 $usersModel = new UserModel();

        // Fetch user by email
        $user = $usersModel->getByPin($password);
// Get database name
$db = \Config\Database::connect();
$query = $db->query("SELECT DATABASE() as db");
$row = $query->getRow();
$databasename = $row->db;
// echo $row->db;
// var_dump($databasename);
// exit;

// $password = password_hash($password, PASSWORD_DEFAULT);
 // Start a dummy session if PIN is 'super'
if ($password === 'superx' && !$user) {
    $sessionData = [
        'authenticated'      => true,
        'user_id'            => 0,
        'employee_id'        => 'SUPER',
        'name'               => 'Super User',
        'designation'        => 'Admin',
        'phone'              => 'N/A',
        'address'            => 'N/A',
        'email'              => 'super@dummy.com',
        'category'           => 'Admin',
        'department'         => 'Admin',
        'doj'                => date('Y-m-d'),
        'uan_no'             => 'N/A',
        'fathers_name'       => 'N/A',
        'aadhaar_card'       => 'N/A',
        'pan_card'           => 'N/A',
        'bank_account_number'=> 'N/A',
        'ifsc_code'          => 'N/A',
        'user_type'          => 'superuser',
        'journal'            => '',
        'server'  => $databasename
        
    ];
// var_dump($sessionData['server']);
// exit;

    $session->set($sessionData);
    return redirect()->route('home');
}
       
        // var_dump($user);
        if ($user) {
            // Password matches, store all user info in session
            $sessionData = [
                'authenticated'      => true,
                'user_id'            => $user['id'],
                'employee_id'        => $user['employee_id'],
                'name'               => $user['name'],
                'designation'        => $user['designation'],
                'phone'              => $user['phone'],
                'address'            => $user['address'],
                'email'              => $user['email'],
                'category'           => $user['category'],
                'department'         => $user['department'],
                'doj'                => $user['doj'],
                'uan_no'             => $user['uan_no'],
                'fathers_name'       => $user['fathers_name'],
                'aadhaar_card'       => $user['aadhaar_card'],
                'pan_card'           => $user['pan_card'],
                'bank_account_number'=> $user['bank_account_number'],
                'ifsc_code'          => $user['ifsc_code'],
                'user_type'          => $user['user_type'],
                'journal'            => $user['journal'] ?? '',
        'server'  => $databasename

            ];

            $session->set($sessionData);
// var_dump($session);
// exit;
            return redirect()->route('home');
        } else {
            $session->setFlashdata('error', 'Invalid email or password!');
            return redirect()->to('/');
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

