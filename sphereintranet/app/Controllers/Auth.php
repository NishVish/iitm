<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

public function attemptLogin()
{
    $session = session();
    $model = new UserModel();

    // $email = trim($this->request->getPost('email'));
    $password = trim($this->request->getPost('password'));

    $user = $model->where('password', $password)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'No user found with this email.');
    }

if ($password === $user['password']) {
$session->set([
    'user_id'              => $user['id'],
    'email'                => $user['email'],
    'username'             => $user['email'],  // Or $user['name'] if preferred
    'user_type'            => $user['category'],
    'employee_id'          => $user['employee_id'],
    'name'                 => $user['name'],
    'designation'          => $user['designation'],
    'phone'                => $user['phone'],
    'address'              => $user['address'],
    'department'           => $user['department'] ?? '',
    'doj'                  => $user['doj'] ?? '',
    'uan_no'               => $user['uan_no'] ?? '',
    'fathers_name'         => $user['fathers_name'] ?? '',
    'aadhaar_card'         => $user['aadhaar_card'] ?? '',
    'pan_card'             => $user['pan_card'] ?? '',
    'bank_account_number'  => $user['bank_account_number'] ?? '',
    'ifsc_code'            => $user['ifsc_code'] ?? '',
    'isLoggedIn'           => true,
]);



        return redirect()->to('/home');
    } else {
        // echo '<pre>';
        // print_r($user);
        // echo '</pre>';
        // exit;

        return redirect()->back()->with('error', 'Invalid credentials.');
    }
}



// public function attemptLogin()
// {
//     $session = session();
//     $model = new UserModel();

//     $email = $this->request->getPost('email');
//     $password = $this->request->getPost('password');

//     $user = $model->where('email', $email)->first();

//     if ($user && $password === $user['password']) {
//         // Set session data
//         $session->set([
//             'user_id'    => $user['id'],
//             'email'      => $user['email'],
//             'username'   => $user['email'],    // Or name if available
//             'user_type'  => $user['category'],
//             'isLoggedIn' => true,
//         ]);

//         return redirect()->to('/dashboard');
//     } else {
//         return redirect()->back()->with('error', 'Invalid credentials.');
//     }
// }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }



public function register()
{
    helper(['form']);

    $model = new UserModel();

    if ($this->request->getMethod() == 'post') {
        // Get input data
        $data = [
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'category' => $this->request->getPost('category'),
        ];

        // Validate input using model rules
        if (!$model->validate($data)) {
            // Validation failed, pass errors to view
            return view('register', [
                'validation' => $model->getValidation(),
                'data' => $data,
            ]);
        }

        // Hash password before saving
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Save user to DB
        $model->save($data);

        // Redirect to login or dashboard
        return redirect()->to('/login')->with('success', 'Registration successful! Please login.');
    }

    return view('register');
}

}
