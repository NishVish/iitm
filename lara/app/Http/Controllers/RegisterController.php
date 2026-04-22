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



        // dd($request->all());
        $database = new DatabaseController();

        $email = $request->email;
        $mobile = $request->phone;
        $company_name = $request->company_name;

        // $email = 'nishwakarma3@gmail.com';
        // $mobile = '7909075195';
        // $company_name = 'Nishwakaram';

        // dd($mobile, $email, $company_name);
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

    public function registaritonsubmit(Request $request)
    {

//         $subcategory = $request->category;
//         $Categorycontroller = new IdentifycategoryController();
//         $checkcateogory = $Categorycontroller->category($subcategory);
//         $checkedcategroyvalue = $checkcateogory->getData()->category;
//         // dd($checkedcategroyvalue);


//         $map = [
//             "Hospitality" => "Hotel",
//             "Travel Agency" => "TA",
//             "Aviation" => "TA",
//             "Transport" => "TA",
//             "MICE" => "TA",
//             "Adventure" => "TA",
//             "TA" => "TA",
//         ];

//         $final_category = $map[$checkedcategroyvalue] ?? "Other";
//         // $subcategory = $request->category;

//         // dd($final_category);

//         $contact_id = $request->contact_id;
//         $company_id = $request->company_id;
//         $event_id = $request->event_id;
//         $event = DB::table('events')
//             ->where('event_id', $event_id)
//             ->first();
//         // dd($request->all());
//         // echo '<pre>';
//         // print_r($request->all());
//         // echo '</pre>';
//         // die();      
//         $eventname = $event->name;
//         // dd($eventname);
//         // 1. UPDATE Master Records

//         // dd($request->all());
//         DB::table('contact')->where('contact_id', $contact_id)->update([
//             'name' => $request->name,
//             'designation' => $request->designation
//         ]);

//         DB::table('contact_mobile')->where('contact_id', $contact_id)->update([
//             'mobile' => $request->mobile
//         ]);

//         DB::table('contact_email')->where('contact_id', $contact_id)->update([
//             'email' => $request->email
//         ]);

//         DB::table('company_data')->where('company_id', $company_id)->update([
//             'company_name' => $request->company_name,
//             'city' => $request->city,
//             'state' => $request->state,
//             'pincode' => $request->pincode,

//             'subcategory' => $request->category,
//             'category' => $final_category,
//             'country' => $request->country,
//             'website' => $request->website,
//             'branch_offices' => $request->branch_offices,
//             'total_staff' => $request->total_staff,
//             'travel_segments' => $request->travel_segments,
//             'meet_profiles' => $request->meet_profiles,
//             'meet_regions' => $request->meet_regions,
//             'interested_states' => $request->interested_states,
//             'database_name' => "online_registration ".$eventname. date('Y'),
//             'entry_type' => 'main',
//             'updated_at' => now()
//         ]);
// // dd($company_id);
// echo $company_id;
// DB::table('company_sources')->insert([
//     'company_id' => $company_id,
//     'notes' => "Online Registration " . $eventname . " " . date('Y'),
//     'event_date' => $event->start_date
// ]);
    
// // dd(request()->all());
// // $allsouce = db::table('company_sources')->where('company_id', "CAC84066E")->get();
// // dd($allsouce);
//         $unique_id = 'CMP_' . uniqid();

//         // 1. company_data
//         // DB::table('company_data')->insert([
//         //     'company_id' => $unique_id,
//         // 2. INSERT Duplicate Registration Entry
//         $databasenew = $eventname." ". date('Y');
//         $newCompanyId = DB::table('company_data')->insertGetId([
//             'company_id' => $unique_id,
//             'company_name' => $request->company_name,
//             'city' => $request->city,
//             'state' => $request->state,
//             'pincode' => $request->pincode,
//             'country' => $request->country,
//             'category' => $final_category,
//             'subcategory' => $request->category,
//             'address' => $request->address,
//             'website' => $request->website,
//             'branch_offices' => $request->branch_offices,
//             'total_staff' => $request->total_staff,
//             'travel_segments' => $request->travel_segments,
//             'meet_profiles' => $request->meet_profiles,
//             'meet_regions' => $request->meet_regions,
//             'interested_states' => $request->interested_states,
//             'entry_type' => 'online_Registration',
//             'cross_validation' => '0',
//             'database_name' => $databasenew,
//             'active_inactive' => 'active',
//             'created_at' => now(),
//             'updated_at' => now()

//         ]);


        

//         $newContactId = DB::table('contact')->insertGetId([
//             'company_id' => $unique_id,
//             'name' => $request->name,
//             'designation' => $request->designation,
//             'created_at' => now()
//         ]);

//         DB::table('contact_mobile')->insert([
//             'contact_id' => $newContactId,
//             'mobile' => $request->mobile,
//             'is_primary' => 1,
//             'created_at' => now()
//         ]);

//         DB::table('contact_email')->insert([
//             'contact_id' => $newContactId,
//             'email' => $request->email,
//             'is_primary' => 1,
//             'created_at' => now()
//         ]);



//         // $category = 'unknown';

//         // if ($request->travel_segments == 'domestic') {
//         //     $category = 'domestic';
//         // } else if ($request->travel_segments == 'international') {
//         //     $category = 'international';
//         // }

//         // 3. Fetch for Preview
//         $dbData = DB::table('contact')
//             ->join('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
//             ->join('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
//             ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
//             ->where('contact.contact_id', $newContactId)
//             ->select('contact.*', 'contact_mobile.mobile', 'contact_email.email', 'company_data.*')
//             ->first();

//         $event = DB::table('events')
//             ->where('event_id', $event_id)
//             ->first();

//         if (!$event) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Event not found'
//             ]);
//         }


//         $eventName = $event->name;
//         $cityName = $event->name;
//         $eventTime = $event->start_date;
//         $companyName = strtolower($request->company_name);
//         $Categorycontroller = new IdentifycategoryController();
//         $checkcateogorycompanyname = $Categorycontroller->category($companyName);
//         $checkedcategroy = $Categorycontroller->category($subcategory);
//         $checkcateogorycompanynamevalue = $checkcateogorycompanyname->getData()->category;
//         $checkedcategroyvalue = $checkcateogory->getData()->category;

//         $final_category_from_company_name = $map[$checkcateogorycompanynamevalue] ?? "Other";
//         $final_category_from_category = $map[$checkedcategroyvalue] ?? "Other";

//         echo "Final Category: " . $final_category . "<br>";
//         echo "Category from Company: " . $final_category_from_company_name . "<br>";
//         echo "Category from Category: " . $final_category_from_category . "<br>";

//         // Use strtolower to make the check case-insensitive
//         if (
//             strtolower($final_category) == 'other' &&
//             strtolower($final_category_from_company_name) == 'other' &&
//             strtolower($final_category_from_category) == 'other'
//         ) {
//             echo "this Is Completely Other";
//             $status = 'Under Review';
//             $message = 'Registration under review...';
//         } else {
//             echo "this Is Completely Approved";
//             $status = 'approved';
//             $message = 'Registration successful!';
//         }
        // dd($status, $message);

       // 4. Mail ONLY if status is 'approved'
     

// Mail::to('marketing1@iitmindia.com')
//     ->send(new RegistrationSuccessMail($data));
   

$data = [
    'company_id'=>$newCompanyId ?? '1',
    'contact_id'=>$newContactId ?? '1',
    'databasename'=>$databasenew ?? '1',
    'eventname' => $eventname ?? 'IITM Kolkata 2026',
    'print' => false,
    'status' => 'success',
    'message' => 'Your registration has been successfully completed',
    'contactName' => $contactName ?? 'Nishant',
        'email' => $email ?? 'marketing1@iitmindia.com',
        'mobile' => $mobile ?? '7909075199',
        'companyName' => $company_name ?? 'ABC Technologies',
      'preview'=>false,
        'emailpage'=>true,



        'sentData' => [
        'contactName' => $contactName ?? 'Nishant',
        'email' => $email ?? 'marketing1@iitmindia.com',
        'mobile' => $mobile ?? '7909075199',
        'company_name' => $company_name ?? 'ABC Technologies',
  
        
    ],
    'dbData' => $dbData ?? [],
];

// dd($data);
// if ($status === 'approved') {
//             Mail::to('marketing1@iitmindia.com')
//     ->send(new RegistrationSuccessMail($data));

//         }
$heool = "heool";
// dd($heool);


     $data['print']=true;
return view('web.registration.success', compact('data'));     // 5. Final Return
        return view('web.registration.success', [
            'sentData' => $request->all(),
            'dbData' => $dbData,
            'eventname' => $eventName,
            'status' => $status,
            'message' => $message,
            'company_name' => $request->company_name
        ]);


        // // 2. Check for existing registration
        // $existing = DB::table('city_event_registrations')
        //     ->where('contact_id', $contact_id)
        //     ->where('city_name', $cityName)
        //     ->first();

        // if ($existing) {
        //     // If they already exist, just send the mail and show the view
        //     Mail::to($request->email)->send(new RegistrationSuccessMail([
        //         'company_name' => $request->company_name,
        //         'eventname' => $eventName,
        //     ]));

        //     return view('web.registration.success', [
        //         'sentData' => $request->all(),
        //         'dbData' => $dbData,
        //         'status' => 'approved', // Keeping your original hardcoded 'approved'
        //         'eventname' => $eventName,
        //         'nameofthecompany' => $request->company_name
        //     ]);
        // } else {
        //     // 3. Perform Insertion
        //     DB::table('city_event_registrations')->insert([
        //         'contact_id' => $contact_id,
        //         'city_name' => $cityName,
        //         'event_name' => $eventName,
        //         'event_time' => $eventTime,
        //     ]);
        // }

        // // 4. Mail ONLY if status is 'approved'
        // if ($status === 'approved') {
        //     Mail::to($request->email)->send(new RegistrationSuccessMail([
        //         'company_name' => $request->company_name,
        //         'eventname' => $eventName,
        //     ]));
        // }

        // // 5. Final Return
        // return view('web.registration.success', [
        //     'sentData' => $request->all(),
        //     'dbData' => $dbData,
        //     'eventname' => $eventName,
        //     'status' => $status,
        //     'message' => $message,
        //     'nameofthecompany' => $request->company_name
        // ]);


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