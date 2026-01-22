<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{

    public function home()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $users = $userModel->findAll(); // Fetch all users

        $data = [
            'title'     => 'Dashboard',
            'user_type' => $session->get('user_type'),
            'username'  => $session->get('username'),
            'user_type' => $session->get('category'), // or change variable names to keep consistent

        ];

        return view('home', $data);
    }


    
}
