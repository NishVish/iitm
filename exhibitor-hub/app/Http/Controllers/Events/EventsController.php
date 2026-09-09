<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;


class EventsController extends Controller
{

    /**
     * Customer landing page
     */
    // public function evenllist()
    // {
    //     $events = EventDetail::all();

    //     return view('exhibitor.index', compact('events'));
    // }



    public function eventlist()
    {



        $events = DB::select("
        SELECT
            event_id,
            year,
            city,
            location
        FROM event_details
        ORDER BY event_id DESC
    ");

        // dd($events);

        return json_encode($events);
    }


}