<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Http\Controllers\DatabaseController;

class AuthController extends Controller
{
    // Show login form

    protected $database;

    public function __construct(DatabaseController $database)
    {
        $this->database = $database;
    }
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

    public function requestOtp(Request $request, $input = null, $eventid = null)
    {

        // dd($request->all());
        $inputValue = $request->input('input');

        if (!$inputValue) {
            return back()->with('error', 'Input is required');
        }

        $mobile = null;
        $email = null;

        if (preg_match('/^[0-9]{10}$/', $inputValue)) {
            $mobile = $inputValue;
        } elseif (filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
            $email = $inputValue;
        } else {
            return back()->with('error', 'Invalid mobile or email');
        }

        // dd($mobile, $email);
        $event = null;
        if ($request->event_id) {
            $event = DB::table('events')
                ->where('event_id', $request->event_id)
                ->first();

            // dd($event);
            if (!$event) {
                return back()->with('error', 'Invalid event ID');
            }
        }

        $contactId = $this->database->getlatestcontactid($mobile, $email);


        $companydata = DB::table('company_data')->where('company_id', $contactId)->first();
        // $entry_type = $companydata->entry_type;
        // do we have any match 
        // yes 

        // is it main lead or online reistration 


        if (!$contactId) {


            $contactId = $this->createnewentry(
                $request->company_name ?? null,
                $mobile,
                $email
            );
        }

        $contactid = $contactId;

        $user = DB::table('contact')
            ->where('contact_id', $contactid)
            ->first();

        if (!$user) {
            return back()->with('error', 'Contact not found');
        }

        $user = (array) $user;

        $user['mobiles'] = DB::table('contact_mobile')
            ->where('contact_id', $contactid)
            ->pluck('mobile')
            ->toArray();

        $user['emails'] = DB::table('contact_email')
            ->where('contact_id', $contactid)
            ->pluck('email')
            ->toArray();

        $company = null;

        if (!empty($user['company_id'])) {
            $company = DB::table('company_data')
                ->where('company_id', $user['company_id'])
                ->first();

            $company = $company ? (array) $company : null;
        }

        session()->put('contact', $user);
        session()->put('company', $company);

        // dd($user, $company, $event);
        return view('web.registration.form', [
            'contact' => $user,
            'company' => $company,
            'eventinfo' => $event,
        ]);
    }



    public function createnewentry($company_name = null, $mobile = null, $email = null)
    {


        DB::beginTransaction();

        try {



            $unique_id = 'CMP_' . uniqid();

            // 1. company_data
            DB::table('company_data')->insert([
                'company_id' => $unique_id,
                'database_name' => "main",
                'outbound' => 0,
                'company_name' => $company_name ?? 'Enter Company Name',
                'category' => null,
                'address' => null,
                'city' => null,
                'pincode' => null,
                'state' => null,
                'country' => null,
                'website' => null,
                'phone' => $mobile,
                'gst_number' => null,
                'sales_person' => null,
                'active_inactive' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
                'session' => 0,
                'cross_validation' => 0,
                'entry_type' => 'main'
            ]);

            // 2. contact
            $contact_id = DB::table('contact')->insertGetId([
                'company_id' => $unique_id,
                'priority' => 1,
                'name' => null,
                'designation' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);


            // 4. contact_email (optional)
            if (!empty($mobile)) {
                // 3. contact_mobile
                DB::table('contact_mobile')->insert([
                    'contact_id' => $contact_id,
                    'mobile' => $mobile,
                    'is_primary' => 1,
                    'created_at' => now()
                ]);
            }

            // 4. contact_email (optional)
            if (!empty($email)) {
                DB::table('contact_email')->insert([
                    'contact_id' => $contact_id,
                    'email' => $email,
                    'is_primary' => 1,
                    'created_at' => now()
                ]);
            }

            DB::commit();

            return $contact_id;

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error("CreateNewEntry failed", [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return null;
        }
    }

    public function verifyOtp(Request $request)
    {
        // $this->requestOtp

        // dd($request->all());
        // $contactid = 317940;

        $contactid = $request->contact_id;
        $otp = $request->otp;

        // $mobile = 7909075195;
        // // dd($mobile);
        // $otp = 762890;
        if (empty($contactid) || empty($otp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number and OTP are required'
            ]);
        }

        $response = $this->verifyUser($contactid, $otp, 'otp');
        // $response = $this->verifyUser(7909075195, 123456, 'otp');
        $data = $response->getData(true);

        if (isset($data['status']) && $data['status'] === 'success' && isset($data['contact'])) {

            $contact = $data['contact'];
            $company = $data['company'] ?? null;
            // dd($company, $contact);
            // exit;
            // Save in session
            session()->put('contact', $contact);
            session()->put('company', $company);
            // session()->put('company_id', $company['company_id'] ?? null);

            //     session(['number' => $request->mobile_number]);
            // session(['is_verified' => true]);

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

    public function temp()
    {
        return view('temp');
    }
    public function verifyUser($contactid = null, $value = null, $type = null)
    {
        // 1. Find the contact
        $user = DB::table('contact')
            ->where('contact_id', $contactid)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact not found'
            ], 404);
        }

        // // 2. Validate OTP or skip validation for 'pass' type
        // $valid = false;

        // if ($type == 'otp') {
        //     $valid = DB::table('contact')
        //         ->where('contact_id', $contactid)
        //         ->where('otp', $value)
        //         ->where('otp_expiry', '>', Carbon::now())
        //         ->exists();

        //     if ($valid) {
        //         DB::table('contact')
        //             ->where('contact_id', $contactid)
        //             ->update([
        //                 'otp' => null,
        //                 'otp_expiry' => null
        //             ]);
        //     }

        // } elseif ($type == 'pass') {
        //     // Plain text match against the contact record
        //     // Replace with Hash::check($value, $user->password) if hashed
        //     $valid = ($user->password ?? null) === $value;

        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Invalid verification type'
        //     ], 422);
        // }

        // // 3. Return error if validation failed
        // if (!$valid) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => $type == 'otp' ? 'Invalid or expired OTP' : 'Invalid password'
        //     ], 422);
        // }

        // Log::info("Login successful via {$type} for contact_id: {$contactid}");
// 1. Find the contact
        $user = DB::table('contact')
            ->where('contact_id', $contactid)
            ->first();
        // 4. Attach mobiles and emails
        $user->mobiles = DB::table('contact_mobile')
            ->where('contact_id', $contactid)
            ->pluck('mobile');

        $user->emails = DB::table('contact_email')
            ->where('contact_id', $contactid)
            ->pluck('email');

        // 5. Fetch company using contact's company_id (not contactid)
        $company = null;
        if (!empty($user->company_id)) {
            $company = DB::table('company_data')
                ->where('company_id', $user->company_id)  // ← was wrongly using $contactid
                ->first();
        }

        return response()->json([
            'status' => 'success',
            'contact' => $user,
            'company' => $company
        ]);
    }

    // public function verifyUser($contactid = Null, $value = null, $type = null)
    // {
    //     // echo $contactid;

    //     // $contactdata = DB::table('contact')
    //     //     ->where('contact_id', $contactid)
    //     //     ->get();
    //     // dd($contactdata);
    //     // exit;
    //     $user = DB::table('contact')
    //         ->where('contact_id', $contactid)
    //         ->first();

    //     // dd($user);
    //     if (!$user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Mobile number not found'
    //         ]);
    //     }
    //     // echo ($user);
    //     // exit;
    //     // 2. Decide if we check OTP or Password
    //     if ($type == 'otp' || $type == 'pass') {
    //         $valid = DB::table('contact')
    //             ->where('contact_id', $contactid)
    //             ->where('otp', $value)
    //             ->where('otp_expiry', '>', Carbon::now())
    //             ->first();

    //         if ($valid || $type == 'pass') {
    //             // Clear OTP after success as per your logic
    //             DB::table('contact')
    //                 ->where('contact_id', $contactid)
    //                 ->update([
    //                     'otp' => null,
    //                     'otp_expiry' => null
    //                 ]);
    //         }
    //     } else {
    //         // Password check (plain text matching)
    //         $valid = DB::table('contact')
    //             ->where('contact_id', $contactid)
    //             // ->where('password', $value)
    //             ->first();
    //     }

    //     // 3. If validation fails for either type
    //     if (!$valid) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid ' . ($type == 'otp' ? 'or expired OTP' : 'password')
    //         ], 422);
    //     }

    //     Log::info("Login successful via $type for mobile: $contactid");

    //     // 4. Fetch the contact profile
    //     $contact = DB::table('contact')
    //         ->where('contact_id', $contactid)
    //         ->first();

    //     if (!$contact) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Contact not found'
    //         ]);
    //     }

    //     // 5. Attach mobiles, emails, and company data
    //     $contact->mobiles = DB::table('contact_mobile')
    //         ->where('contact_id', $contactid)
    //         ->pluck('mobile');

    //     $contact->emails = DB::table('contact_email')
    //         ->where('contact_id', $contactid)
    //         ->pluck('email');

    //     $company = null;
    //     if (!empty($contact->company_id)) {
    //         $company = DB::table('company_data')
    //             ->where('company_id', $contactid)
    //             ->first();
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'contact' => $contact,
    //         'company' => $company
    //     ]);
    // }

    public function getOtp()
    {
        // $rawotplist = DB::table('contact')->whereNotNull('otp')->get();
        // echo ($rawotplist);
        // exit;
        $otps = DB::table('contact as c')
            ->select(
                'c.contact_id',
                'c.name',
                'c.otp',
                'c.otp_expiry',
                'cm.mobile',
                'ce.email'
            )
            ->leftJoin('contact_mobile as cm', 'cm.contact_id', '=', 'c.contact_id')
            ->leftJoin('contact_email as ce', 'ce.contact_id', '=', 'c.contact_id')
            ->whereNotNull('c.otp')
            ->orderByDesc('c.otp_expiry')
            ->limit(100)
            ->get();
        return view('otp_list_view', compact('otps'));
    }

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
