<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // <--- Import your new Model

class App extends Controller
{
    public function index(Request $request)
    {
        // Use the Model method instead of DB::table
        $events = Event::getEventsWithLatestLayout(1);
        // var_dump($events);
        // exit;

        // Debugging to see the new structure (it will include 'latest_layout' relationship)
        // dd($events->toArray()); 

        $routeName = $request->route()->getName();
        $path = $request->path();

        return view('app', [
            'events' => $events,
            'routeName' => $routeName,
            'path' => $path,
        ]);
    }
}