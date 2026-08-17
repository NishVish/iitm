<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Http\Controllers\Registration\CategoryVerification;
use App\Http\Controllers\Registration\Save;
class RegistrationController extends Controller
{
    public function index()
    {


        return view('choose');
    }

    public function eventlist()
    {


        return view('eventlist.index');
    }


    public function registrationpage()
    {


        return view('form.index');
    }

    public function review()
    {


        return view('review.index');
    }


    public function store(Request $request)
    {

        // dd($request->all());

        $verification = new CategoryVerification();

        $isVerified = $verification->verification($request->all());

        // dd($isVerified);

        if ($isVerified) {
            $save = new Save();
            $companyId = $save->store($request->all());
            dd($companyId);

            return view('badge.index');
        }

        return redirect(url('review'));

        return view('register.badge');

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'organization' => 'required',
            'designation' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'website' => 'required',
            'Message' => 'required',
            'city_name' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validation->messages(),
            ]);
        } else {
            $registration = Registration::create($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Registration created successfully',
            ]);
        }


        return view('form.index');
    }
}