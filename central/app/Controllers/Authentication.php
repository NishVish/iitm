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
// $password = password_hash($password, PASSWORD_DEFAULT);

        $usersModel = new UserModel();

        // Fetch user by email
        $user = $usersModel->getByPin($password);
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
                'journal'            => $user['journal'] ?? ''
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

