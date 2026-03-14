<?php
namespace App\Controllers;

use App\Models\MasterModel;
use App\Models\EventModel; // Import the Event Model

class Mainmenu extends BaseController {

    public function index()
    {
        // 1. Initialize the Event Model
        $eventModel = new EventModel();

        // 2. Fetch events using the method we optimized earlier 
        // (This includes the layout_info join)
        $data['events'] = $eventModel->getEventsWithLatestLayout();

        // 3. Pass the $data array to the view
        return view('app', $data);
    }
}