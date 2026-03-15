<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\EventModel;

class Mobile extends BaseController
{

public function index()
    {
        // 1. Initialize the Event Model
        $eventModel = new EventModel();

        // 2. Fetch events using the method we optimized earlier 
        // (This includes the layout_info join)
        $data['events'] = $eventModel->getEventsWithLatestLayout();

        // 3. Pass the $data array to the view
        return view('mobile', $data);
    }

}

