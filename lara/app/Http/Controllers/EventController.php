<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function getUpcomingEvents()
    {
        // Fetch all upcoming events ordered by date
        $events = DB::table('events')
        ->where('start_date', '>=', date('Y-m-d'))
        ->orderBy('start_date', 'asc')
        ->get();
            // var_dump($events);
            // exit;

        // Return as JSON so your JavaScript can read it
        return response()->json($events);
    }

    
        public function lastEventDetails($id=null)
    {
        // Fetch all upcoming events ordered by date
        $events = DB::table('events')
        ->where('start_date', '>=', date('Y-m-d'))
        ->orderBy('start_date', 'asc')
        ->first();
            // var_dump($events);
            // exit;    

        // Return as JSON so your JavaScript can read it
        return response()->json($events);
    }
}