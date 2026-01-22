<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Dash extends Controller
{
    public function home()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard',
            'user_type' => $session->get('user_type'),
            'username' => $session->get('username'),
        ];

        return view('home', $data);
    }
}