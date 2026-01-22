<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\Controller;

class Event extends Controller
{
    public function index()
    {
        $model = new EventModel();
        $events = $model->findAll(); // Fetch all records

        return $this->response->setJSON($events); // Return as JSON
    }
}
