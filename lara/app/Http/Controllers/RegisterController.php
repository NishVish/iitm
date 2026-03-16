<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function index($location = null)
    {
        // Fetch all records from the "events" table using Laravel's DB facade
        $events = DB::table('events')->get();
        // where('name', $location); like %location and year is current year
        $events = DB::table('events')->where('name', 'like', '%' . $location . '%')->where('year', date('Y'))->get();
        
        
        var_dump($events);
        // exit;
        return view('register.index', ['location' => $location ?? '', 'events' => $events]);
    }

    /**
     * Handle registration submission.
     */
    public function store(Request $request)
    {
        // TODO: add validation and persistence logic here

        return redirect()->back()->with('success', 'Registration submitted successfully.');
    }
}

