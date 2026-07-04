<?php

namespace App\Http\Controllers;

use Faker\Guesser\Name;
use Illuminate\Bus\UpdatedBatchJobCounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\PostCondition;
use PHPUnit\Framework\TestSize\Unknown;
use Symfony\Component\VarDumper\VarDumper;
use App\Http\Controllers\IdentifycategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessMail;
use function Illuminate\Support\years;
use Carbon\Carbon;
use App\Http\Controllers\MailerController;
use App\Http\Controllers\Mail\MailServices;


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
    public function emailtemplate($event = null)
    {
        $data = [
            'company_name' => 'Demo Company Pvt Ltd',
            'eventname' => $event ?? 'Tech Expo 2026',
        ];

        return view('emails.registration_success', compact('data'));
    }
    public function registration_form($event = null)
    {
        $contact = session()->get('contact');
        $company = session()->get('company');

        echo "<pre>";
        // print_r($contact);
        print_r($company);
        echo "</pre>";
        return view('web.registration.form', compact('contact', 'company'));

        // exit;
        // It's good practice to ensure both exist before proceeding
        if ($contact && $company) {
        } else {
            return redirect()->route('register')
                ->with('error', 'Session expired. Please verify again.');
        }
    }

    public function register_enquiry(Request $request)
    {

        // // dd($request->all());
        // echo "<pre>";
        // print_r($request->all());
        // $this->createentry($request, 'lead');
        // echo "</pre>";
        // echo "<pre>";
        // print_r($request->all());
        // $this->createentry($request, 'main');
        // echo "</pre>";


        $company_name = $request->company_name;
        $contact_name = $request->contact_name;
        $designation = $request->designation;
        $email = $request->email;
        $phone = $request->phone;
        $category = $request->category;
        $cities = $request->cities; // array

        $this->createentry($request, 'lead');
        $this->createentry($request, 'main');
        return view('web.registration.enquirysuccess', compact('company_name', 'contact_name', 'designation', 'email', 'phone', 'category', 'cities'));


    }

    public function createentry($request, $type)
    {
        // dd($request->all());
        // echo "<pre>";
        // print_r($type);
        // echo "</pre>";
        $company_name = $request->company_name;
        $contact_name = $request->contact_name;
        $designation = $request->designation;
        $email = $request->email;
        $city = urlencode($request->city);

        $url = "https://nominatim.openstreetmap.org/search?city={$city}&format=json&addressdetails=1&limit=1";

        $options = [
            "http" => [
                "header" => "User-Agent: MyApp/1.0\r\n"
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);

        $state = $data[0]['address']['state'] ?? null;

        // echo $state;
        // exit;
        $phone = $request->phone;
        $category = $request->category;
        $cities = $request->cities; // array
        $message = $request->message;

        DB::beginTransaction();

        try {

            $unique_id = 'CMP_' . uniqid();

            // 1. company_data
            DB::table('company_data')->insert([
                'company_id' => $unique_id,
                'database_name' => "Online_enquiry_" . date('Y'),
                'outbound' => 0,
                'company_name' => $company_name ?? 'Enter Company Name',
                'category' => $category, // FIXED
                'address' => $city,      // FIXED (or full address if you have)
                'city' => $city,
                'pincode' => null,
                'state' => $state,
                'country' => null,
                'website' => null,
                'phone' => $phone,
                'gst_number' => null,
                'sales_person' => null,
                'active_inactive' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
                'session' => 0,
                'cross_validation' => 0,
                'entry_type' => $type
            ]);

            // 2. contact
            $contact_id = DB::table('contact')->insertGetId([
                'company_id' => $unique_id,
                'priority' => 1,
                'name' => $contact_name,   // FIXED
                'designation' => $designation,    // FIXED
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 3. contact_mobile
            if (!empty($phone)) {
                DB::table('contact_mobile')->insert([
                    'contact_id' => $contact_id,
                    'mobile' => $phone,
                    'is_primary' => 1,
                    'created_at' => now()
                ]);
            }

            // 4. contact_email
            if (!empty($email)) {
                DB::table('contact_email')->insert([
                    'contact_id' => $contact_id,
                    'email' => $email,
                    'is_primary' => 1,
                    'created_at' => now()
                ]);
            }
            DB::table("company_sources")->insert([
                "company_id" => $unique_id,
                "notes" => "Online Enquiry -" . date('Y'),
                "created_at" => now()
            ]);

            DB::commit();

            // return $contact_id;

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
        if ($type == 'lead') {
            // dd($type);

            $lead_id = DB::table('leads')->insertGetId([
                'company_id' => $unique_id,
                'contact_id' => $contact_id,
                'exhibition_year' => date('Y'),
                'fascia' => null,
                'sales_person' => null,
                'exhibitor' => $company_name,
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if (!empty($cities)) {
                foreach ($cities as $loc) {


                    // DB::table('orders')->insert([
                    //     'lead_id' => $lead_id,
                    //     'type' => 'stall',
                    //     'specification' => null,

                    //     'price' => 0,
                    //     'gst' => 0,
                    //     'discount' => 0,

                    //     'paid_amount' => 0,

                    //     'status' => 'pending',
                    // ]);

                    DB::table('lead_locations')->insert([
                        'lead_id' => $lead_id,
                        'location' => $loc,     // Delhi, Ahmedabad, etc.
                        'stall_location' => null,
                        'size' => null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }




    }
    public function register_enquiryx(Request $request)
    {



        dd($request->all());


        $database = new DatabaseController();

        $email = $request->email;
        $mobile = $request->phone;
        $company_name = $request->company_name;

        // $email = 'nishwakarma3@gmail.com';
        // $mobile = '7909075195';
        // $company_name = 'Nishwakaram';

        dd($mobile, $email, $company_name);
        // ---------------------------------------------------------------
        // STEP 1: Get the latest contact ID by mobile or email
        // ---------------------------------------------------------------
        $contactid = $database->getLatestContactId($mobile, $email);

        // dd($contactid);
        if (!$contactid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact not found for provided email or mobile'
            ], 404);
        }

        // ---------------------------------------------------------------
        // STEP 2: Load existing contact, mobile, email, company records
        // ---------------------------------------------------------------
        $contactdata = DB::table('contact')
            ->where('contact_id', $contactid)
            ->first();

        if (!$contactdata) {
            return response()->json([
                'status' => 'error',
                'message' => 'Contact record not found'
            ], 404);
        }

        $companyData = null;
        if (!empty($contactdata->company_id)) {
            $companyData = DB::table('company_data')
                ->where('company_id', $contactdata->company_id)  // ← was using $contactid
                ->first();
        }

        $mobileRecord = DB::table('contact_mobile')
            ->where('contact_id', $contactid)
            ->where('is_primary', 1)
            ->first();

        $emailRecord = DB::table('contact_email')
            ->where('contact_id', $contactid)
            ->where('is_primary', 1)
            ->first();

        DB::beginTransaction();

        try {
            // ---------------------------------------------------------------
            // STEP 3: Duplicate company as a new lead
            // ---------------------------------------------------------------
            $unique_company_id = 'CMP_' . uniqid();

            if ($companyData) {
                $newCompanyData = (array) $companyData;
                unset($newCompanyData['id']);                          // remove auto-increment PK
                $newCompanyData['company_id'] = $unique_company_id;
                $newCompanyData['company_name'] = $company_name ?? $companyData->company_name;
                $newCompanyData['entry_type'] = 'lead';
                $newCompanyData['created_at'] = now();
                $newCompanyData['updated_at'] = now();
            } else {
                // No existing company — create a fresh one from request
                $newCompanyData = [
                    'company_id' => $unique_company_id,
                    'company_name' => $company_name ?? 'Unknown',
                    'entry_type' => 'lead',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('company_data')->insert($newCompanyData);

            // ---------------------------------------------------------------
            // STEP 4: Duplicate contact under the new lead company
            // ---------------------------------------------------------------
            $contactDataArr = (array) $contactdata;
            unset($contactDataArr['contact_id']);             // remove PK — auto-incremented
            $contactDataArr['company_id'] = $unique_company_id;
            $contactDataArr['created_at'] = now();
            $contactDataArr['updated_at'] = now();
            $contactDataArr['otp'] = null;           // clear sensitive fields
            $contactDataArr['otp_expiry'] = null;

            $new_contact_id = DB::table('contact')->insertGetId($contactDataArr);

            // ---------------------------------------------------------------
            // STEP 5: Duplicate primary mobile to new contact
            // ---------------------------------------------------------------
            if ($mobileRecord) {
                $mobileArr = (array) $mobileRecord;
                unset($mobileArr['mobile_id']);
                $mobileArr['contact_id'] = $new_contact_id;
                $mobileArr['created_at'] = now();
                DB::table('contact_mobile')->insert($mobileArr);
            } elseif ($mobile) {
                // No existing record — insert raw value from request
                DB::table('contact_mobile')->insert([
                    'contact_id' => $new_contact_id,
                    'mobile' => $mobile,
                    'is_primary' => 1,
                    'created_at' => now(),
                ]);
            }

            // ---------------------------------------------------------------
            // STEP 6: Duplicate primary email to new contact
            // ---------------------------------------------------------------
            if ($emailRecord) {
                $emailArr = (array) $emailRecord;
                unset($emailArr['email_id']);
                $emailArr['contact_id'] = $new_contact_id;
                $emailArr['created_at'] = now();
                DB::table('contact_email')->insert($emailArr);
            } elseif ($email) {
                // No existing record — insert raw value from request
                DB::table('contact_email')->insert([
                    'contact_id' => $new_contact_id,
                    'email' => $email,
                    'is_primary' => 1,
                    'created_at' => now(),
                ]);
            }

            // ---------------------------------------------------------------
            // STEP 7: If company_name changed, update both original + lead
            // ---------------------------------------------------------------
            if ($companyData && !empty($company_name) && $company_name !== $companyData->company_name) {
                DB::table('company_data')
                    ->where('company_id', $companyData->company_id)
                    ->update(['company_name' => $company_name, 'updated_at' => now()]);

                DB::table('company_data')
                    ->where('company_id', $unique_company_id)
                    ->update(['company_name' => $company_name, 'updated_at' => now()]);
            }

            DB::commit();

            // ---------------------------------------------------------------
            // STEP 8: Return the new lead contact for the success view
            // ---------------------------------------------------------------
            $leadContact = DB::table('contact')
                ->where('contact_id', $new_contact_id)
                ->first();

            $contactDataArr = (array) $leadContact;

            return view('web.registration.enquirysuccess', compact('contactDataArr'));

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('register_enquiry failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }
    //     public fucntion checkifleadexist(request $request){

    // use numer to find contact id    


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



    // }


    public function showleads()
    {
        $contactDataArr = [
            "company_id" => "CMP_69e3590bd9c85",
            "priority" => 1,
            "name" => "Nishant Vishwakarma",
            "designation" => "Data Analyst",
            "image" => null,
            "created_at" => "2026-04-18T10:12:27.899816Z",
            "updated_at" => "2026-04-18T10:12:27.899833Z",
            "attendance_reason" => null,
            "buyer_responsibility" => null,
            "attended_past" => "No",
            "interest_forum" => "No",
            "business_card_path" => null,
            "otp" => null,
            "otp_expiry" => null
        ];
        return view('web.registration.view.enquiry', compact('contactDataArr'));
    }

    public function showtradevisitor()
    {
        $contactDataArr = [
            "company_id" => "CMP_69e3590bd9c85",
            "priority" => 1,
            "name" => "Nishant Vishwakarma",
            "designation" => "Data Analyst",
            "image" => null,
            "created_at" => "2026-04-18T10:12:27.899816Z",
            "updated_at" => "2026-04-18T10:12:27.899833Z",
            "attendance_reason" => null,
            "buyer_responsibility" => null,
            "attended_past" => "No",
            "interest_forum" => "No",
            "business_card_path" => null,
            "otp" => null,
            "otp_expiry" => null
        ];
        return view('web.registration.view.tradevisitor', compact('contactDataArr'));
    }

    // private function getFinalCategory($input)
    // {
    //     $Categorycontroller = new IdentifycategoryController();
    //     $response = $Categorycontroller->category($input);

    //     $categoryValue = $response->getData()->category ?? null;

    //     $map = [
    //         "Hospitality" => "Hotel",
    //         "Travel Agency" => "TA",
    //         "Aviation" => "TA",
    //         "Transport" => "TA",
    //         "MICE" => "TA",
    //         "Adventure" => "TA",
    //         "TA" => "TA",
    //     ];

    //     return $map[$categoryValue] ?? "Other";
    // }


    public function registaritonsubmit(Request $request)
    {


        // $subcategory = $request->subcategory;

        $final_category = $this->getFinalCategory($request->category);
        // $subcategory = $request->category;

        // dd($final_category);

        // dd($request->all());
        $contact_id = $request->contact_id;
        $company_id = $request->company_id;
        $event_id = $request->event_id;
        $event = DB::table('events')
            ->where('event_id', $event_id)
            ->first();
        // dd($request->all());
        // echo '<pre>';
        // print_r($request->all());
        // print_r($event);
        // echo '</pre>';
        // die();
        $eventname = $event->name;
        // dd($eventname);
        // 1. UPDATE Master Records
        $contactName = $request->name;
        // dd($request->all());
        DB::table('contact')->where('contact_id', $contact_id)->update([
            'name' => $request->name,
            'designation' => $request->designation
        ]);

        DB::table('contact_mobile')->where('contact_id', $contact_id)->update([
            'mobile' => $request->mobile
        ]);

        DB::table('contact_email')->where('contact_id', $contact_id)->update([
            'email' => $request->email
        ]);

        DB::table('company_data')->where('company_id', $company_id)->update([
            'company_name' => $request->company_name,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            // 'subcategory' => $request->subcategory,
            'category' => $request->final_category,
            'country' => $request->country,
            'website' => $request->website,
            'branch_offices' => $request->branch_offices,
            'total_staff' => $request->total_staff,
            'travel_segments' => $request->travel_segments,
            'meet_profiles' => $request->meet_profiles,
            'meet_regions' => $request->meet_regions,
            'interested_states' => $request->interested_states,
            'database_name' => "online_registration " . $eventname . date('Y'),
            'entry_type' => 'main',
            'updated_at' => now()
        ]);
        // dd($company_id);
        // echo $company_id;
        DB::table('company_sources')->insert([
            'company_id' => $company_id,
            'notes' => "Online Registration " . $eventname . " " . date('Y'),
            'event_date' => $event->start_date
        ]);


        $oldCompanydata = DB::table('company_data')->where('company_id', $company_id)->first();
        $isChanged =
            !$oldCompanydata ||
            $oldCompanydata->company_name !== $request->company_name ||
            $oldCompanydata->city !== $request->city ||
            $oldCompanydata->state !== $request->state ||
            $oldCompanydata->pincode !== $request->pincode;

        if ($isChanged) {
            $unique_id = 'CMP_' . uniqid();

            $databasenew = $eventname . " " . date('Y');

            $newCompanyId = DB::table('company_data')->insertGetId([
                'company_id' => $unique_id,
                'company_name' => $request->company_name,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => $request->country,
                // 'subcategory' => $request->subcategory,
                'category' => $request->final_category,
                'address' => $request->address,
                'website' => $request->website,
                'branch_offices' => $request->branch_offices,
                'total_staff' => $request->total_staff,
                'travel_segments' => $request->travel_segments,
                'meet_profiles' => $request->meet_profiles,
                'meet_regions' => $request->meet_regions,
                'interested_states' => $request->interested_states,
                'entry_type' => 'main',
                'cross_validation' => '0',
                'database_name' => $databasenew,
                'active_inactive' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $newContactId = DB::table('contact')->insertGetId([
                'company_id' => $unique_id,
                'name' => $request->name,
                'designation' => $request->designation,
                'created_at' => now()
            ]);

            DB::table('contact_mobile')->insert([
                'contact_id' => $newContactId,
                'mobile' => $request->mobile,
                'is_primary' => 1,
                'created_at' => now()
            ]);

            DB::table('contact_email')->insert([
                'contact_id' => $newContactId,
                'email' => $request->email,
                'is_primary' => 1,
                'created_at' => now()
            ]);
            DB::table('company_sources')->insert([
                'company_id' => $company_id,
                'notes' => "Online Registration " . $eventname . " " . date('Y'),
                'event_date' => $event->start_date
            ]);
        } else {
            DB::table('company_data')->where('company_id', $company_id)->update([
                'company_name' => $request->company_name,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                // 'subcategory' => $request->subcategory,
                'category' => $request->final_category,
                'country' => $request->country,
                'website' => $request->website,
                'branch_offices' => $request->branch_offices,
                'total_staff' => $request->total_staff,
                'travel_segments' => $request->travel_segments,
                'meet_profiles' => $request->meet_profiles,
                'meet_regions' => $request->meet_regions,
                'interested_states' => $request->interested_states,
                'database_name' => "online_registration " . $eventname . date('Y'),
                'entry_type' => 'main',
                'updated_at' => now()
            ]);
            // dd($company_id);
            // echo $company_id;
            DB::table('company_sources')->insert([
                'company_id' => $company_id,
                'notes' => "Online Registration " . $eventname . " " . date('Y'),
                'event_date' => $event->start_date
            ]);
        }
        DB::table('company_sources')->insert([
            'company_id' => $company_id,
            'notes' => "Online Registration " . $eventname . " " . date('Y'),
            'event_date' => $event->start_date
        ]);
        // dd(request()->all());
// $allsouce = db::table('company_sources')->where('company_id', "CAC84066E")->get();
// dd($allsouce)
        $unique_id = 'CMP_' . uniqid();
        // 1. company_data
        // DB::table('company_data')->insert([
        //     'company_id' => $unique_id,
        // 2. INSERT Duplicate Registration Entry
        $databasenew = $eventname . " " . date('Y');
        $newCompanyId = DB::table('company_data')->insertGetId([
            'company_id' => $unique_id,
            'company_name' => $request->company_name,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'country' => $request->country,
            'subcategory' => $request->subcategory,
            'category' => $request->category,
            'address' => $request->address,
            'website' => $request->website,
            'branch_offices' => $request->branch_offices,
            'total_staff' => $request->total_staff,
            'travel_segments' => $request->travel_segments,
            'meet_profiles' => $request->meet_profiles,
            'meet_regions' => $request->meet_regions,
            'interested_states' => $request->interested_states,
            'entry_type' => 'online_Registration',
            'cross_validation' => '0',
            'database_name' => $databasenew,
            'active_inactive' => 'active',
            'created_at' => now(),
            'updated_at' => now()

        ]);




        $newContactId = DB::table('contact')->insertGetId([
            'company_id' => $unique_id,
            'name' => $request->name,
            'designation' => $request->designation,
            'created_at' => now()
        ]);

        DB::table('contact_mobile')->insert([
            'contact_id' => $newContactId,
            'mobile' => $request->mobile,
            'is_primary' => 1,
            'created_at' => now()
        ]);

        DB::table('contact_email')->insert([
            'contact_id' => $newContactId,
            'email' => $request->email,
            'is_primary' => 1,
            'created_at' => now()
        ]);





        // 3. Fetch for Preview
        $dbData = DB::table('contact')
            ->join('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->join('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('contact.contact_id', $newContactId)
            ->select('contact.*', 'contact_mobile.mobile', 'contact_email.email', 'company_data.*')
            ->first();

        $event = DB::table('events')
            ->where('event_id', $event_id)
            ->first();

        if (!$event) {
            return response()->json([
                'status' => false,
                'message' => 'Event not found'
            ]);
        }


        // Vendue Senction
        $email = $dbData->email;
        $mobile = $dbData->mobile;

        $db = $databasenew;
        $venue = null;
        $all_dates = [];
        $eventname = $db;

        // -----------------------------
        // EVENT PARSING (NAME + YEAR)
        // -----------------------------
        $parts = explode(' ', trim($db));
        $year = end($parts);
        $name = trim(str_replace($year, '', $db));

        $eventdetails = DB::table("events")
            ->where('name', $name)
            ->where('year', $year)
            ->first();

        if ($eventdetails) {

            $startdate = $eventdetails->start_date;
            $enddate = $eventdetails->end_date;

            if (!empty($startdate) && !empty($enddate)) {

                $start = Carbon::parse($startdate);
                $end = Carbon::parse($enddate);

                while ($start->lte($end)) {
                    $all_dates[] = $start->format('Y-m-d');
                    $start->addDay();
                }
            }

            $venue = $eventdetails->venue_details;
        }

        // dd($all_dates);


        $eventName = $event->name;
        $cityName = $event->name;
        $eventTime = $event->start_date;
        $companyName = $request->company_name ?? '';
        $category = $request->category ?? '';
        $subcategory = $request->subcategory ?? '';

        // $companyFinal = strtolower($this->getFinalCategory('travel') ?? '');

        // // doesthis
        // // companynamecontains
        // // theses
        // // keyords
        // $categoryFinal = strtolower($this->getFinalCategory($category) ?? '');



        // echo "</pre>";
        // die;

        // echo "<pre>";
        // print_r($companyName);
        // echo "<br>";
        // print_r($category);
        // Logic check
        $companyFinal = $this->getFinalCategory($companyName); // e.g. "Hilton" -> "hotel"
        $categoryFinal = $this->getFinalCategory($category); // e.g. "MICE" -> "ta"

        if ($categoryFinal === 'uncategorized' && $companyFinal === 'uncategorized') {
            $status = 'Under Review';
            $message = 'Registration under review...';
        } else {
            $status = 'approved';
            $message = 'Registration successful!';
        }

        if ($category == "other_general") {
            $status = 'Under Review';
            $message = 'Registration under review...';
        }
        // echo "<pre>";
        // print_r($categoryFinal);
        // echo "<br>";
        // print_r($companyFinal);
        // dd($status);

        // dd($email);
        $cleanName = preg_replace('/^(mr\.?|mrs\.?|ms\.?)\s+/i', '', $contactName);
        $newCompanyId = $unique_id;

        $contactName = $cleanName;
        $data = [
            'company_id' => $newCompanyId ?? '1',
            'contact_id' => $newContactId ?? '1',
            'databasename' => $databasenew ?? '1',
            'eventname' => $eventname ?? 'IITM Kolkata 2026',
            'print' => true,
            'status' => 'success',
            'message' => 'Your registration has been successfully completed',
            'contactName' => $contactName ?? 'Nishant',
            'email' => $email ?? 'marketing1@iitmindia.com',
            'mobile' => $mobile ?? '7909075199',
            'city' => $request->city ?? 'N/A',
            'companyName' => $companyName ?? 'ABC Technologies',
            'preview' => false,
            'emailpage' => true,
            'all_dates' => $all_dates,
            'venue' => $venue,


            'sentData' => [
                'contactName' => $contactName ?? 'Nishant',
                'email' => $email ?? 'marketing1@iitmindia.com',
                'mobile' => $mobile ?? '7909075199',
                'company_name' => $companyName ?? 'ABC Technologies',


            ],
            'dbData' => $dbData ?? [],
        ];

        // dd($data);

        // echo "<pre>";
// print_r($data);
// echo "</pre>";


        // $result = \Illuminate\Support\Facades\Http::post(url('/mail/registration'), $data);

        // dd($result);

        if ($status === 'approved') {
            // echo "<pre>";
            // echo "thsi is approved";
            // echo "</pre>";
            // $mailer = new MailServices();

            // $mailer->sendRegistrationMail($data);




            $data['print'] = true;
            $data['preview'] = false;
            $data['emailpage'] = true;



            return view('web.registration.successpage.index', compact('data'));

            // 5. Final Return

        }

        // return view('web.registration.underreview', compact('data'));     // 5. Final Return

        //  echo "<pre>";
        //  echo "<div
        //  style='background-color:black;'>";
        //  print_r($data);
        //  echo "</div>";
        //  echo "</pre>";





    }
    public function register_now(Request $request)
    {
        return view('web.participant.index');
    }
    private function getFinalCategory($input)
    {
        if ($input == "other_general") {
            return 'uncategorized';
        }
        $input = strtolower(trim($input));

        // 1. Direct bypass case
        if ($input === 'other_general' || empty($input)) {
            return 'uncategorized';
        }

        // 2. Define Map (Moved to top so it's accessible)
        $map = [
            'hospitality' => 'hotel',
            'hotel' => 'hotel',
            'resort' => 'hotel',
            'travel agency' => 'ta',
            'aviation' => 'ta',
            'transport' => 'ta',
            'mice' => 'ta',
            'adventure' => 'ta',
            'ta' => 'ta',
            'travel' => 'ta',
        ];

        // 3. Call category API
        $Categorycontroller = new IdentifycategoryController();
        $foundCategory = $Categorycontroller->isInDictionary($input);

        // 4. Return mapped value or fallback
        if ($foundCategory && isset($map[$foundCategory])) {
            return $map[$foundCategory];
        }

        return 'uncategorized';
    }
    public function category($nameofthecompany)
    {
        // 1. Path to dictionary
        $path = public_path('assets/dictionary.json');

        // 2. Check if file exists
        if (!file_exists($path)) {
            return 'Uncategorized';
        }
        // 3. Read and decode
        $json = file_get_contents($path);
        $dictionary = json_decode($json, true);

        // Ensure company name is a string and clean
        $companyName = strtolower(trim($nameofthecompany));

        // 4. Keyword Search Logic
        // foreach ($dictionary as $item) {
        //     $keyword = strtolower($item['keyword'] ?? '');

        //     // Use stripos to check if the keyword exists ANYWHERE in the company name
        //     if ($keyword !== '' && stripos($companyName, $keyword) !== false) {
        //         if (!empty($item['category'])) {
        //             return $item['category'];
        //         }

        //         // Fallback: Google search URL
        //         $query = urlencode($keyword);
        //         return "https://www.google.com/search?q=" . $query;

        //     }
        // }
        // $this->search($nameofthecompany);
        return view('web.search', compact('nameofthecompany'));

    }

    public function search($nameofthecompany)
    {

        echo "hello";

        $query = urlencode($nameofthecompany);
        $url = "https://www.google.com/search?q={$query}";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

        $html = curl_exec($ch);
        curl_close($ch);

        $results = [];

        // Parse Google results (basic DOM scraping)
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);

        // Google result titles are usually in <h3>
        $nodes = $xpath->query('//h3');

        foreach ($nodes as $node) {
            $results[] = $node->textContent;
        }

        return view('web.search', compact('nameofthecompany', 'results'));
    }


    private function getbackgroundinfo($companyname, $mobile, $email)
    {



    }



    public function registaritonsudbmit(Request $request)
    {
        $contact_id = $request->contact_id;
        $company_id = $request->company_id;

        // 1. Update Contact Tables
        DB::table('contact')->where('contact_id', $contact_id)->update([
            'name' => $request->name,
            'designation' => $request->designation,
        ]);

        DB::table('contact_mobile')->where('contact_id', $contact_id)->update([
            'mobile' => $request->mobile,
        ]);

        DB::table('contact_email')->where('contact_id', $contact_id)->update([
            'email' => $request->email,
        ]);



        // 2. Update Company Table (Table name corrected to company_data)
        DB::table('company_data')->where('company_id', $company_id)->update([
            'company_name' => $request->company_name,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'country' => $request->country,
            'website' => $request->website,
        ]);

        // 3. Fetch all updated data using Joins
        $dbData = DB::table('contact')
            ->join('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->join('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            // Corrected table name to company_data
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('contact.contact_id', $contact_id)
            ->select(
                'contact.name',
                'contact.designation',
                'contact_mobile.mobile',
                'contact_email.email',
                'company_data.company_name',
                'company_data.city',
                'company_data.website'
            )
            ->first();

        // 4. Send to view
        return view('web.registration.success', [
            'sentData' => $request->all(),
            'dbData' => $dbData
        ]);

    }

    public function registrationsuccestemplate()
    {
        $data = [
            'company_name' => 'Acme Travel Solutions',
            'email' => 'test@example.com',
            'contact_id' => '123'
        ];

        $dbData = (object) [
            'name' => 'John Doe'
        ];

        $eventName = "IITM Mumbai 2026";
        $status = 'Under Review';

        return view('emails.registration_success', [
            'data' => $data,
            'dbData' => $dbData,
            'eventName' => $eventName,
            'status' => $status
        ]);
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


    // categories = {
//     "Hospitality": [
//         "hotel", "resort", "inn", "suites", "stay", "hostel", "lodge", "villa", 
//         "palace", "heritage", "boutique", "homestay", "bnb", "motel", "apartment", 
//         "residence", "manor", "chateau", "cottage", "cabin", "bungalow", "sanctuary", 
//         "retreat", "spa", "wellness", "house", "luxury", "grand", "plaza", "continental"
//     ],
//     "Travel Agency": [
//         "travel", "tour", "tourism", "vacation", "holiday", "expedition", "voyage", 
//         "trip", "getaway", "destination", "itinerary", "world", "global", "leisure", 
//         "discovery", "explore", "pathfinder", "nomad", "wander", "compass", "horizon", 
//         "dmc", "inbound", "outbound", "domestic", "international", "agency", "operator"
//     ],
//     "Aviation": [
//         "airline", "airway", "aviation", "flight", "charter", "airbus", "boeing", 
//         "jet", "heli", "helicopter", "aerospace", "sky", "wing", "propeller", 
//         "pilot", "airport", "terminal", "lounge", "ground handling", "cargo"
//     ],
//     "Transport": [
//         "shuttle", "cab", "taxi", "transport", "car rental", "limo", "coach", "bus", 
//         "rail", "train", "ferry", "cruise", "liner", "ship", "yacht", "fleet", 
//         "logistic", "mover", "transfer", "rideshare", "metro", "express", "way"
//     ],
//     "MICE": [
//         "mice", "event", "expo", "exhibition", "forum", "conference", "summit", 
//         "meeting", "incentive", "organizer", "planner", "convention", "venue", 
//         "trade fair", "seminar", "workshop", "banquet", "gala", "association"
//     ],
//     "Adventure": [
//         "adventure", "trek", "safari", "wildlife", "camping", "eco", "climb", 
//         "hike", "mountaineer", "rafting", "scuba", "dive", "surf", "ski", 
//         "snow", "backpacker", "trail", "wilderness", "peak", "summit", "nature"
//     ],
//     "Services": [
//         "visa", "forex", "insurance", "passport", "consulate", "guide", "exchange", 
//         "currency", "concierge", "assistance", "billing", "payment", "booking", 
//         "reservation", "marketing", "consultancy", "solutions"
//     ],
//     "Niche": [
//         "pilgrim", "spiritual", "yatra", "darshan", "ayurveda", "yoga", "medical", 
//         "health", "golf", "culinary", "food", "wine", "cruise", "educational", 
//         "volunteer", "agritourism", "rural"
//     ]
// }
// import json
// dictionary = []
// for category, keywords in categories.items():
//     for word in keywords:
//         dictionary.append({
//             "keyword": word,
//             "category": category
//         })
// print(json.dumps(dictionary, indent=2))
}


// public function registaritonsubmit(Request $request)
// {

//     // $data = $request->all();
//     // dd($data);

//     $conctact_id = $request->contact_id;

//     DB::table('contact')->where('contact_id', $conctact_id)->update([
//         'name' => $request->name,
//         'designation' => $request->designation,

//     ]);
//     DB::table('contact_mobile')->where('contact_id', $conctact_id)->update([
//         'mobile' => $request->mobile,

//     ]);
//     DB::table('contact_email')->where('contact_id', $conctact_id)->update([
//         'email' => $request->email,
//         // 'designation' => $request->designation,

//     ]);

//     // db'mobile' => $request->mobile,
//     //     'email' => $request->email,


//     $company_id = $request->company_id;

//     // return response()->json([
//     //     'contact_id' => $conctact_id,
//     //     'company_id' => $company_id,
//     // ]);
//     // DB::table('registrations')->insert([
//     //     'name' => $request->name,
//     //     'designation' => $request->designation,
//     //     'mobile' => $request->mobile,
//     //     'email' => $request->email,
//     //     'company_name' => $request->company_name,
//     //     'city' => $request->city,
//     //     'state' => $request->state,
//     //     'pincode' => $request->pincode,
//     //     'country' => $request->country,
//     //     'website' => $request->website,
//     //     'travel_segments' => $request->travel_segments,
//     //     'meet_profiles' => $request->meet_profiles,
//     //     'meet_regions' => $request->meet_regions,
//     //     'interested_states' => $request->interested_states,
//     //     'attending_reason' => $request->attending_reason,
//     //     'buyer_responsibility' => $request->buyer_responsibility,
//     //     'branch_offices' => $request->branch_offices,
//     //     'total_staff' => $request->total_staff,
//     //     'attended_ttf_before' => $request->attended_ttf_before,
//     //     'interested_in_forum' => $request->interested_in_forum,
//     //     'referral_details' => $request->referral_details,
//     // ]);
//     // Basic fields
//     $name = $request->name;
//     $designation = $request->designation;
//     $mobile = $request->mobile;
//     $email = $request->email;

//     // Company
//     $company_name = $request->company_name;
//     $city = $request->city;
//     $state = $request->state;
//     $pincode = $request->pincode;
//     $country = $request->country;
//     $website = $request->website;

//     // Arrays (checkbox)
//     $travel_segments = $request->travel_segments ?? [];
//     $meet_profiles = $request->meet_profiles ?? [];
//     $meet_regions = $request->meet_regions ?? [];
//     $interested_states = $request->interested_states ?? [];

//     // Business
//     $attending_reason = $request->attending_reason;
//     $buyer_responsibility = $request->buyer_responsibility;
//     $branch_offices = $request->branch_offices;
//     $total_staff = $request->total_staff;

//     // Event
//     $attended_ttf_before = $request->attended_ttf_before;
//     $interested_in_forum = $request->interested_in_forum;

//     // Referral
//     $referral_details = $request->referral_details;

//     var_dump($request->all());
//     // exit;
//     // return view('web.registration.formdata', compact('request'));
//     return view('web.registration.success', compact('request'));
// }