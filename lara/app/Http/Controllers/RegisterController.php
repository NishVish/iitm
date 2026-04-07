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
        if ($location == 'form') {
            return $this->registration_form();
        }
        // Fetch all records from the "events" table using Laravel's DB facade
        $events = DB::table('events')->get();
        // where('name', $location); like %location and year is current year
        $events = DB::table('events')->where('name', 'like', '%' . $location . '%')->where('year', date('Y'))->get();


        var_dump($events);
        // exit;
        return view('web.register', ['location' => $location ?? '', 'events' => $events]);
    }


    public function registration_form()
    {
        // This will print all session data in a readable format and stop execution
        // You should see 'contact', 'company', and 'company_id' here
        // dd(session()->all());

        // Once you confirm the data is there, you can use this logic:
        $contact = session()->get('contact');
        $company = session()->get('company');
        // $company_id = session()->get('company_id');

        echo "<pre>";
        print_r($contact);
        print_r($company);
        echo "</pre>";
        exit;
        if ($contact) {
            return view('web.registration.form', compact('contact'));
        } else {
            return redirect()->route('register')->with('error', 'Session expired. Please verify again.');
        }
    }
    public function index2($location = null)
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

