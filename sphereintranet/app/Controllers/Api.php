<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Api extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        // Fetch all data from the users table
        $users = $this->model->findAll();

        // Return the data as JSON
        return $this->respond($users);
    }
}
