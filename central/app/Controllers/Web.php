<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Web extends BaseController
{


    public function index()
    {
        header("Location: https://iitmindia.com");
        exit;
    }

}
