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
    public function login()
    {

        $mobile = $request->mobile_number;
        $otp = $request->otp;
        var_dump($mobile);
        var_dump($otp);
        exit;

        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->intended('/dashboard'); // Redirect to intended page
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
        if(empty($mobile)){
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
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number not found'
            ]);
            // return redirect('http://localhost/iitm/central/registration/mobile/notfound');
        }
    
        // Generate OTP
        $otp = rand(100000,999999);
        $expiry = Carbon::now()->addMinutes(10);
    
        $updated = DB::table('contact')
            ->where('contact_id',$user->contact_id)
            ->update([
                'otp' => $otp,
                'otp_expiry' => $expiry
            ]);
    
        // var_dump($updated);
        // exit;
        if($updated){
    
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
    // $mobile = '8792548508';
    $otp = $request->otp;

    if (empty($mobile) || empty($otp)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Mobile number and OTP are required'
        ]);
    }

    // Check if mobile exists
    $user = DB::table('contact_mobile')
        ->where('mobile', $mobile)
        ->first();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Mobile number not found'
        ]);
    }

    // Check if OTP is valid
    $validOtp = DB::table('contact')
        ->where('contact_id', $user->contact_id)
        ->where('otp', $otp)
        ->where('otp_expiry', '>', Carbon::now())
        ->first();

    if (!$validOtp) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or expired OTP'
        ]);
    }

    // Clear OTP after successful verification
    DB::table('contact')
        ->where('contact_id', $user->contact_id)
        ->update([
            'otp' => null,
            'otp_expiry' => null
        ]);

    // Log the successful login
    Log::info("Login successful for mobile: $mobile");

    // Get contact data
    // Fetch contact data
    $contact = DB::table('contact')
        ->where('contact_id', $user->contact_id)
        ->first();

    if (!$contact) {
        return response()->json([
            'status' => 'error',
            'message' => 'Contact not found'
        ]);
    }

    // Get all mobiles for the contact
    $mobiles = DB::table('contact_mobile')
        ->where('contact_id', $user->contact_id)
        ->pluck('mobile');

    // Get all emails for the contact
    $emails = DB::table('contact_email')
        ->where('contact_id', $user->contact_id)
        ->pluck('email');

    // Add mobiles and emails into contact object
    $contact->mobiles = $mobiles;
    $contact->emails = $emails;

    // Get company data for this contact
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
            ->select('c.contact_id','c.name','c.otp','c.otp_expiry','cm.mobile')
            ->leftJoin('contact_mobile as cm','cm.contact_id','=','c.contact_id')
            ->whereNotNull('c.otp')
            ->orderBy('c.otp_expiry','desc')
            ->get();
    
        return view('otp_list_view', compact('otps'));
    }
    
}