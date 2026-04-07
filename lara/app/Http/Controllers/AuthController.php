<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show login form
    public function loginpage()
    {
        return view('login'); // login.blade.php
    }

    // Handle login form submission
    public function login(Request $request)
    {
        // var_dump("super");
        // exit;

        $password = $request->password;

        $mobile = $request->mobile;
        var_dump($mobile);
        var_dump($password);
        // exit;

        // // get contact id from mobile number
// // get company id from contact id
// // get pin from company id

        // check is password is correct
        $response = $this->verifyUser($mobile, $password, 'password');
        $data = $response->getData(true);

        // 1. Check if the 'status' is success AND the keys exist
        if (isset($data['status']) && $data['status'] === 'success' && isset($data['contact'])) {

            $contact = $data['contact'];
            $company = $data['company'];

            session()->put('contact', $contact);
            session()->put('company', $company);

            // Use a persistent company_id for middleware checks later
            session()->put('company_id', $company['company_id']);

            return redirect()->route('home');
        }


        // Failed login
        return back()->with('error', 'Invalid credentials')->withInput();
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Create user
    public function create(Request $request)
    {
        return redirect('http://localhost/iitm/central/registration/mobile/x');
    }


    public function requestOtp(Request $request)
    {
        $mobile = $request->mobile_number;
        // $mobile = '8792548508';
        if (empty($mobile)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number is required'
            ]);
        }

        // var_dump($mobile);
        // exit;
        // Check if mobile exists
        $user = DB::table('contact_mobile')
            ->where('mobile', $mobile)
            ->first();

        // var_dump($user);
        // exit;
        if (!$user) {


            // create an entry with mobile number
            // first company id is 1
            // $new_user = DB::table('contact_mobile')->insert([
            //     'mobile' => $mobile,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number not found'
            ]);
            // return redirect('http://localhost/iitm/central/registration/mobile/notfound');
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $expiry = Carbon::now()->addMinutes(10);

        $updated = DB::table('contact')
            ->where('contact_id', $user->contact_id)
            ->update([
                'otp' => $otp,
                'otp_expiry' => $expiry
            ]);

        // var_dump($updated);
        // exit;
        if ($updated) {

            Log::debug("OTP for $mobile is: $otp");

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to save OTP'
        ]);
    }


    public function verifyOtp(Request $request)
    {
        $mobile = $request->mobile_number;
        $otp = $request->otp;

        if (empty($mobile) || empty($otp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number and OTP are required'
            ]);
        }

        $response = $this->verifyUser($mobile, $otp, 'otp');
        $data = $response->getData(true);

        if (isset($data['status']) && $data['status'] === 'success' && isset($data['contact'])) {

            $contact = $data['contact'];
            $company = $data['company'] ?? null;

            // Save in session
            session()->put('contact', $contact);
            session()->put('company', $company);
            session()->put('company_id', $company['company_id'] ?? null);

            return response()->json([
                'status' => 'success',
                'contact' => $contact,
                'company' => $company
            ]);
        }

        // OTP invalid
        return response()->json([
            'status' => 'error',
            'message' => $data['message'] ?? 'Invalid OTP or Verification Failed'
        ]);
    }
    //     public function verifyOtp(Request $request)
// {


    //     $mobile = $request->mobile_number;
//     // $mobile = '8792548508';
//     $otp = $request->otp;
//     $type = 'login';
//     // $otp = 508845;
// // var_dump($mobile);
// // var_dump($otp);
// // exit;
//     if (empty($mobile) || empty($otp)) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Mobile number and OTP are required'
//         ]);
//     }

    // $response = $this->verifyUser($mobile, $otp, 'otp');
// $data = $response->getData(true); 

    // // var_dump($data);
// // exit;

    // // 1. Check if the 'status' is success AND the keys exist
// if (isset($data['status']) && $data['status'] === 'success' && isset($data['contact'])) {

    //     $contact = $data['contact'];
//     $company = $data['company'];

    //         session()->put('contact', $contact);
//         session()->put('company', $company);

    //         // Use a persistent company_id for middleware checks later
//         session()->put('company_id', $company['company_id']); 


    // if ($type == "login") {
//     session()->put('contact', $contact);
//     session()->put('company', $company);
//     return redirect()->route('home');
// } else {
// return response()->json([
//     'status' => 'success',
//     'contact' => $contact,
//     'company' => $company
// ]);}

    // }

    // // 2. If we reached here, something went wrong (Wrong OTP, etc.)
// // We redirect back with the error message returned by your verifyUser function
// return redirect()->back()->with('error', $data['message'] ?? 'Invalid OTP or Verification Failed');
// // Now you can access them (Note: getData() usually returns objects by default)
// // var_dump($contact);
// // var_dump($company);
//     // return route('mobile');


    // }


    public function verifyUser($mobile, $value, $type)
    {
        // 1. Find the user by mobile
        $user = DB::table('contact_mobile')
            ->where('mobile', $mobile)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number not found'
            ]);
        }

        // 2. Decide if we check OTP or Password
        if ($type == 'otp' || $type == 'pass') {
            $valid = DB::table('contact')
                ->where('contact_id', $user->contact_id)
                ->where('otp', $value)
                ->where('otp_expiry', '>', Carbon::now())
                ->first();

            if ($valid || $type == 'pass') {
                // Clear OTP after success as per your logic
                DB::table('contact')
                    ->where('contact_id', $user->contact_id)
                    ->update([
                        'otp' => null,
                        'otp_expiry' => null
                    ]);
            }
        } else {
            // Password check (plain text matching)
            $valid = DB::table('contact')
                ->where('contact_id', $user->contact_id)
                // ->where('password', $value)
                ->first();
        }

        // 3. If validation fails for either type
        if (!$valid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ' . ($type == 'otp' ? 'or expired OTP' : 'password')
            ], 422);
        }

        Log::info("Login successful via $type for mobile: $mobile");

        // 4. Fetch the contact profile
        $contact = DB::table('contact')
            ->where('contact_id', $user->contact_id)
            ->first();

        if (!$contact) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact not found'
            ]);
        }

        // 5. Attach mobiles, emails, and company data
        $contact->mobiles = DB::table('contact_mobile')
            ->where('contact_id', $user->contact_id)
            ->pluck('mobile');

        $contact->emails = DB::table('contact_email')
            ->where('contact_id', $user->contact_id)
            ->pluck('email');

        $company = null;
        if (!empty($contact->company_id)) {
            $company = DB::table('company_data')
                ->where('company_id', $contact->company_id)
                ->first();
        }

        return response()->json([
            'status' => 'success',
            'contact' => $contact,
            'company' => $company
        ]);
    }



    public function getOtp()
    {
        $otps = DB::table('contact as c')
            ->select('c.contact_id', 'c.name', 'c.otp', 'c.otp_expiry', 'cm.mobile')
            ->leftJoin('contact_mobile as cm', 'cm.contact_id', '=', 'c.contact_id')
            ->whereNotNull('c.otp')
            ->orderBy('c.otp_expiry', 'desc')
            ->get();

        return view('otp_list_view', compact('otps'));
    }

}