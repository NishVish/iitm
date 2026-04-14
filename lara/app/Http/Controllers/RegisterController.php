<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\PostCondition;

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
        return view('web.registration.index', ['location' => $location ?? '', 'events' => $events]);
    }

    public function registration_form()
    {
        $contact = session()->get('contact');
        $company = session()->get('company');

        // echo "<pre>";
        // print_r($contact);
        // print_r($company);
        // echo "</pre>";
        // exit;
        // It's good practice to ensure both exist before proceeding
        if ($contact && $company) {
            return view('web.registration.form', compact('contact', 'company'));
        } else {
            return redirect()->route('register')
                ->with('error', 'Session expired. Please verify again.');
        }
    }




    public function registaritonsubmit(Request $request)
    {

        // $data = $request->all();
        // dd($data);

        $conctact_id = $request->contact_id;

        DB::table('contact')->where('contact_id', $conctact_id)->update([
            'name' => $request->name,
            'designation' => $request->designation,

        ]);
        DB::table('contact_mobile')->where('contact_id', $conctact_id)->update([
            'mobile' => $request->mobile,

        ]);
        DB::table('contact_email')->where('contact_id', $conctact_id)->update([
            'email' => $request->email,
            // 'designation' => $request->designation,

        ]);

        // db'mobile' => $request->mobile,
        //     'email' => $request->email,


        $company_id = $request->company_id;

        // return response()->json([
        //     'contact_id' => $conctact_id,
        //     'company_id' => $company_id,
        // ]);
        // DB::table('registrations')->insert([
        //     'name' => $request->name,
        //     'designation' => $request->designation,
        //     'mobile' => $request->mobile,
        //     'email' => $request->email,
        //     'company_name' => $request->company_name,
        //     'city' => $request->city,
        //     'state' => $request->state,
        //     'pincode' => $request->pincode,
        //     'country' => $request->country,
        //     'website' => $request->website,
        //     'travel_segments' => $request->travel_segments,
        //     'meet_profiles' => $request->meet_profiles,
        //     'meet_regions' => $request->meet_regions,
        //     'interested_states' => $request->interested_states,
        //     'attending_reason' => $request->attending_reason,
        //     'buyer_responsibility' => $request->buyer_responsibility,
        //     'branch_offices' => $request->branch_offices,
        //     'total_staff' => $request->total_staff,
        //     'attended_ttf_before' => $request->attended_ttf_before,
        //     'interested_in_forum' => $request->interested_in_forum,
        //     'referral_details' => $request->referral_details,
        // ]);
        // Basic fields
        $name = $request->name;
        $designation = $request->designation;
        $mobile = $request->mobile;
        $email = $request->email;

        // Company
        $company_name = $request->company_name;
        $city = $request->city;
        $state = $request->state;
        $pincode = $request->pincode;
        $country = $request->country;
        $website = $request->website;

        // Arrays (checkbox)
        $travel_segments = $request->travel_segments ?? [];
        $meet_profiles = $request->meet_profiles ?? [];
        $meet_regions = $request->meet_regions ?? [];
        $interested_states = $request->interested_states ?? [];

        // Business
        $attending_reason = $request->attending_reason;
        $buyer_responsibility = $request->buyer_responsibility;
        $branch_offices = $request->branch_offices;
        $total_staff = $request->total_staff;

        // Event
        $attended_ttf_before = $request->attended_ttf_before;
        $interested_in_forum = $request->interested_in_forum;

        // Referral
        $referral_details = $request->referral_details;



        return view('web.registration.formdata', compact('request'));
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

