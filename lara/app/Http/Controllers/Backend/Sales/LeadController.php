<?php

namespace App\Http\Controllers\Backend\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\DatabaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Email;
use PhpOption\None;

class LeadController extends Controller
{
    public function index($found = true)
    {
        if ($found) {
            return view('backend.sales.index');
        } else {
            return view('backend.sales.index', compact('found'));
        }
    }

    public function allleads()
    {
        $userdata = session()->get('user');
        $username = $userdata->name ?? null;

        $leads = DB::table('leads')
            ->when($username, function ($query) use ($username) {
                $query->where('sales_person', $username);
            })
            ->get();
        // ✅ FIXED (important)
        $leadIds = $leads->pluck('lead_id')->filter()->unique();
        $companyIds = $leads->pluck('company_id')->filter()->unique();
        $contactIds = $leads->pluck('contact_id')->filter()->unique();

        // 2. Related data
        $companies = DB::table('company_data')
            ->whereIn('company_id', $companyIds)
            ->get()
            ->keyBy('company_id');

        $contacts = DB::table('contact')
            ->whereIn('contact_id', $contactIds)
            ->get()
            ->keyBy('contact_id');

        $mobiles = DB::table('contact_mobile')
            ->whereIn('contact_id', $contactIds)
            ->where('is_primary', 1)
            ->get()
            ->keyBy('contact_id');

        $emails = DB::table('contact_email')
            ->whereIn('contact_id', $contactIds)
            ->where('is_primary', 1)
            ->get()
            ->keyBy('contact_id');

        // 3. Locations (FIXED)
        $locations = DB::table('lead_locations')
            ->whereIn('lead_id', $leadIds)
            ->get()
            ->groupBy('lead_id');

        // 4. Orders
        $orders = DB::table('orders')
            ->whereIn('lead_id', $leadIds)
            ->get()
            ->groupBy('lead_id');

        // 5. Final mapping
        $leads = $leads->map(function ($lead) use ($companies, $contacts, $mobiles, $emails, $orders, $locations) {
            return (object) [
                'lead' => $lead,
                'company' => $companies[$lead->company_id] ?? null,
                'contact' => $contacts[$lead->contact_id] ?? null,
                'mobile' => $mobiles[$lead->contact_id] ?? null,
                'email' => $emails[$lead->contact_id] ?? null,

                // ✅ clean naming
                'locations' => $locations[$lead->lead_id] ?? collect(),
                'orders' => $orders[$lead->lead_id] ?? collect(),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $leads->values(), // clean index
        ]);
    }

    //     public function allleads()
//     {
//         $userdata = session()->get('user');
//         $userid = $userdata->name;

    //         $allleads = DB::table('leads')
//             ->leftJoin('contact_mobile', 'leads.contact_id', '=', 'contact_mobile.contact_id')
//             ->where('leads.sales_person', $userid)
//             ->select(
//                 'leads.*',
//                 'contact_mobile.mobile'
//             )
//             ->get();
// Table: company_data
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// id	int	11	Yes	No	NULL
// company_id	varchar	50	No	No	NULL
// database_name	varchar	100	No	Yes	NULL
// outbound	tinyint	4	No	Yes	0
// company_name	varchar	255	No	No	NULL
// category	varchar	100	No	Yes	NULL
// subcategory	varchar	100	No	Yes	NULL
// address	text		No	Yes	NULL
// city	varchar	100	No	Yes	NULL
// pincode	varchar	20	No	Yes	NULL
// state	varchar	100	No	Yes	NULL
// country	varchar	100	No	Yes	NULL
// website	varchar	255	No	Yes	NULL
// phone	varchar	50	No	Yes	NULL
// gst_number	varchar	50	No	Yes	NULL
// sales_person	varchar	100	No	Yes	NULL
// active_inactive	enum		No	Yes	active
// created_at	timestamp		No	No	current_timestamp()
// updated_at	varchar	25	No	Yes	NULL
// last_confirmed_at	datetime		No	Yes	NULL
// session	int	11	No	No	0
// cross_validation	tinyint	1	No	No	NULL
// last_comments	text		No	Yes	NULL
// second_last_comments	text		No	Yes	NULL
// updated_by	text		No	Yes	NULL
// second_last_comments_updated_by	text		No	Yes	NULL
// entry_type	enum		No	No	NULL
// pin	varchar	20	No	Yes	NULL
// travel_segments	text		No	Yes	NULL
// meet_profiles	text		No	Yes	NULL
// meet_regions	text		No	Yes	NULL
// interested_states	text		No	Yes	NULL
// branch_offices	varchar	50	No	Yes	NULL
// total_staff	varchar	50	No	Yes	NULL
// association_membership	varchar	255	No	Yes	NULL

    // Table: contact
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// contact_id	int	11	Yes	No	NULL
// company_id	varchar	50	No	No	NULL
// priority	tinyint	4	No	Yes	1
// name	varchar	255	No	Yes	NULL
// designation	varchar	100	No	Yes	NULL
// image	varchar	255	No	Yes	NULL
// created_at	timestamp		No	No	current_timestamp()
// updated_at	datetime		No	Yes	NULL
// attendance_reason	varchar	100	No	Yes	NULL
// buyer_responsibility	varchar	100	No	Yes	NULL
// attended_past	enum		No	Yes	No
// interest_forum	enum		No	Yes	No
// business_card_path	varchar	255	No	Yes	NULL
// otp	varchar	6	No	Yes	NULL
// otp_expiry	datetime		No	Yes	NULL
// Table: contact_email
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// email_id	int	11	Yes	No	NULL
// contact_id	int	11	No	No	NULL
// email	varchar	100	No	No	NULL
// is_primary	tinyint	4	No	Yes	0
// created_at	timestamp		No	No	current_timestamp()
// updated_at	timestamp		No	Yes	NULL
// Table: contact_mobile
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// mobile_id	int	11	Yes	No	NULL
// contact_id	int	11	No	No	NULL
// mobile	varchar	50	No	No	NULL
// is_primary	tinyint	4	No	Yes	0
// created_at	timestamp		No	No	current_timestamp()
// updated_at	timestamp		No	Yes	NULL
// Table: discussion
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// discussion_id	int	11	Yes	No	NULL
// lead_id	varchar	50	No	No	NULL
// action	varchar	100	No	Yes	NULL
// message	text		No	Yes	NULL
// discussion_date	datetime		No	Yes	current_timestamp()
// Table: invoices
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// invoice_id	int	11	No	No	NULL
// invoice_number	varchar	100	No	Yes	NULL
// lead_id	varchar	50	No	Yes	NULL
// company_id	varchar	50	No	Yes	NULL
// base_amount	decimal	10	No	Yes	NULL
// gst_amount	decimal	10	No	Yes	NULL
// total_amount	decimal	10	No	Yes	NULL
// invoice_date	date		No	Yes	NULL
// pdf_path	varchar	255	No	Yes	NULL
// created_at	timestamp		No	No	current_timestamp()
// Table: lead_locations
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// location_id	int	11	Yes	No	NULL
// lead_id	int	11	No	No	NULL
// location	varchar	100	No	Yes	NULL
// stall_location	varchar	100	No	Yes	NULL
// size	varchar	50	No	Yes	NULL
// created_at	timestamp		No	No	current_timestamp()
// updated_at	datetime		No	Yes	NULL
// Table: lead_quotations
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// quotation_id	int	11	Yes	No	NULL
// lead_id	int	11	No	No	NULL
// subtotal	decimal	10	No	Yes	0.00
// gst_amount	decimal	10	No	Yes	0.00
// discount_amount	decimal	10	No	Yes	0.00
// grand_total	decimal	10	No	Yes	0.00
// status	varchar	50	No	Yes	draft
// created_at	timestamp		No	No	current_timestamp()
// Table: leads
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// lead_id	int	11	Yes	No	NULL
// company_id	varchar	50	No	No	NULL
// contact_id	int	11	No	Yes	NULL
// exhibition_year	int	11	No	Yes	NULL
// exhibitor	varchar	255	No	Yes	NULL
// sales_person	varchar	100	No	Yes	NULL
// fascia	varchar	100	No	Yes	NULL
// status	varchar	50	No	Yes	draft
// created_at	timestamp		No	No	current_timestamp()
// updated_at	datetime		No	Yes	NULL
// Table: payments
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// payment_id	int	11	Yes	No	NULL
// lead_id	int	11	No	No	NULL
// amount	decimal	10	No	No	NULL
// payment_mode	varchar	50	No	Yes	NULL
// payment_status	varchar	50	No	Yes	pending
// transaction_ref	varchar	100	No	Yes	NULL
// payment_date	datetime		No	Yes	NULL
// created_at	timestamp		No	No	current_timestamp()
// Table: quotation_items
// Column Name	Type	Max Length	Primary Key	Nullable	Default
// item_id	int	11	Yes	No	NULL
// quotation_id	int	11	No	No	NULL
// location_id	int	11	No	Yes	NULL
// description	varchar	255	No	Yes	NULL
// price	decimal	10	No	Yes	0.00
// gst_amount	decimal	10	No	Yes	0.00
// discount	decimal	10	No	Yes	0.00
// total	decimal	10	No	Yes	0.00


    //         return response()->json([
//             'status' => 'success',
//             'data' => $allleads,
//         ]);
//     }
    public function createlead(Request $request)
    {
        // dd($request->all());
        $databasecontroller = new DatabaseController();

        $duplicate = $databasecontroller->createduplicate(
            $request->company_id,
            $request->contact_id,
            'lead'
        );

        $duplicateData = $duplicate->getData(true);

        $unique_id = $duplicateData['new_company_id'] ?? null;
        $newContactId = $duplicateData['new_contact_id'] ?? null;

        $userdata = session()->get('user');
        $userid = $userdata->name ?? null;

        $leadId = DB::table('leads')->insertGetId([
            'company_id' => $unique_id,
            'contact_id' => $newContactId,
            'exhibitor' => $request->exhibitor,
            'exhibition_year' => $request->exhibition_year,
            'sales_person' => $userid,
            'status' => 'draft',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $locations = $request->stall_location ?? [];

        foreach ($locations as $i => $loc) {
            DB::table('lead_locations')->insert([
                'lead_id' => $leadId,
                'location' => $loc,
                'stall_location' => $request->stall_location[$i] ?? null,
                'size' => $request->size[$i] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->back();


        // return response()->json([
        //     'status' => 'success',
        //     'lead_id' => $leadId
        // ]);
    }

    public function leadsdetails(Request $request, $id, $review = false)
    {
        $bookingid = $id;
        // echo "<pre>";
        // print_r($bookingid);

        $mobile = $request->mobile;
        // print_r($mobile);

        // echo "</pre>";
        // die;
        // 1. Get lead with contact
        $lead = DB::table('leads')
            ->where('lead_id', $bookingid)
            ->first();


        if (!$lead) {
            return redirect()
                ->back()
                ->with('error', 'No booking found for this ID. Please try again.');
        }
        // 2. Check mobile against contact_mobile table
        $contactMobile = DB::table('contact_mobile')
            ->where('contact_id', $lead->contact_id)
            ->where('mobile', $mobile)
            ->first();

        if (!$contactMobile) {
            return redirect()
                ->back()
                ->with('error', 'Mobile number not matched. Please try again.');
        }

        // 3. Get full contact details
        $contact = DB::table('contact')
            ->where('contact_id', $lead->contact_id)
            ->first();

        // 4. Emails
        $emails = DB::table('contact_email')
            ->where('contact_id', $lead->contact_id)
            ->get();

        // 5. Mobiles
        $mobiles = DB::table('contact_mobile')
            ->where('contact_id', $lead->contact_id)
            ->get();

        // return view('booking.index', compact(
        //     'lead',
        //     'contact',
        //     'emails',
        //     'mobiles'
        // ));
        // dd($review);
        // Lead + Company + Contact (Main Info)
        return $this->getdetails($id, false);

    }


    // public function getdetails($id, $review)
    // {
    //     // dd($id, $review);
    //     $lead = DB::table('leads as l')
    //         ->leftJoin('company_data as c', 'l.company_id', '=', 'c.company_id')
    //         ->leftJoin('contact as ct', 'l.contact_id', '=', 'ct.contact_id')
    //         ->select(
    //             'l.*',
    //             'c.company_name',
    //             'c.address',
    //             'c.city',
    //             'c.state',
    //             'c.country',
    //             'c.gst_number',
    //             'c.website',
    //             'c.phone',
    //             'ct.name as contact_name',
    //             'ct.designation'
    //         )
    //         ->where('l.lead_id', $id)
    //         ->first();

    //     if (!$lead) {

    //         return view('web.participant.form.enquiry-form');
    //     }
    //     $leadinfo = DB::table('leads as l')
    //         ->leftJoin('lead_locations as ll', 'l.lead_id', '=', 'll.lead_id')
    //         ->where('l.lead_id', $id)
    //         ->first();
    //     // dd($leadinfo);
    //     $company = DB::table('company_data')->where('company_id', $lead->company_id)->first();
    //     $contact = DB::table('contact')->where('contact_id', $lead->contact_id)->first();
    //     // Emails
    //     $emails = DB::table('contact_email')
    //         ->where('contact_id', $lead->contact_id ?? 0)
    //         ->get();

    //     // Mobiles
    //     $mobiles = DB::table('contact_mobile')
    //         ->where('contact_id', $lead->contact_id ?? 0)
    //         ->get();
    //     // dd($company, $contact, $mobiles);

    //     // Stall / Location Details
    //     $locations = DB::table('lead_locations')
    //         ->where('lead_id', $id)
    //         ->get();

    //     // Company Source (Event Info)
    //     $sources = DB::table('company_sources')
    //         ->where('company_id', $lead->company_id ?? '')
    //         ->get();

    //     $orders = DB::table('orders')
    //         ->where('lead_id', $id)
    //         ->get();


    //     echo "<pre>";
    //     // print_r($lead);

    //     print_r($locations);
    //     // print_r($sources);
    //     // print_r($company);
    //     // print_r($contact);
    //     // print_r($emails);
    //     // print_r($mobiles);
    //     print_r($leadinfo);
    //     print_r("order");
    //     // print_r($orders);
    //     echo "</pre>";
    //     // exit;
    //     if ($review) {
    //         return view('booking.review', compact(
    //             'lead',
    //                             'leadinfo',

    //             'emails',
    //             'mobiles',
    //             'locations',
    //             'sources',
    //             'company',
    //             'contact',
    //             'orders'
    //         ));
    //     }
    //     return view('booking.index', compact(
    //         'lead',
    //         'emails',
    //         'mobiles',
    //         'locations',
    //         'sources',
    //         'company',
    //         'contact',
    //         'leadinfo',
    //         'orders'
    //     ));



    // }


    public function getdetails($id, $review)
    {
        $lead = DB::table('leads as l')
            ->leftJoin('company_data as c', 'l.company_id', '=', 'c.company_id')
            ->leftJoin('contact as ct', 'l.contact_id', '=', 'ct.contact_id')
            ->select(
                'l.*',
                'c.company_name',
                'c.address',
                'c.city',
                'c.state',
                'c.country',
                'c.gst_number',
                'c.website',
                'c.phone',
                'ct.name as contact_name',
                'ct.designation'
            )
            ->where('l.lead_id', $id)
            ->first();

        if (!$lead) {
            return view('web.participant.form.enquiry-form');
        }

        // ✅ CLEAN separation
        $leadinfo = $lead;

        $locations = DB::table('lead_locations')
            ->where('lead_id', $id)
            ->get();

        $orders = DB::table('orders')
            ->where('lead_id', $id)
            ->get();

        $company = DB::table('company_data')
            ->where('company_id', $lead->company_id)
            ->first();

        $contact = DB::table('contact')
            ->where('contact_id', $lead->contact_id)
            ->first();

        $emails = DB::table('contact_email')
            ->where('contact_id', $lead->contact_id ?? 0)
            ->get();

        $mobiles = DB::table('contact_mobile')
            ->where('contact_id', $lead->contact_id ?? 0)
            ->get();

        $sources = DB::table('company_sources')
            ->where('company_id', $lead->company_id ?? '')
            ->get();

        if ($review) {
            return view('booking.review', compact(
                'leadinfo',
                'locations',
                'orders',
                'emails',
                'mobiles',
                'sources',
                'company',
                'contact',
                'lead'
            ));
        }

        return view('booking.index', compact(
            'leadinfo',
            'locations',
            'orders',
            'emails',
            'mobiles',
            'sources',
            'company',
            'contact',
            'lead'
        ));
    }

    public function finalizelead(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // return;
        DB::beginTransaction();

        try {

            /* -------------------------
            | 1. COMPANY DATA
            --------------------------*/
            DB::table('company_data')->updateOrInsert(
                ['company_id' => $request->company_id],
                [
                    'company_name' => $request->company_name,
                    'website' => $request->website,
                    'address' => $request->address,
                    'gst_number' => $request->gst_number,
                    // 'phone' => $request->phone,
                    'sales_person' => $request->sales_person,
                    'updated_at' => now(),
                ]
            );

            /* -------------------------
            | 2. CONTACT
            --------------------------*/
            $contact = DB::table('contact')
                ->where('contact_id', $request->contact_id)
                ->first();

            if ($contact) {

                DB::table('contact')
                    ->where('contact_id', $request->contact_id)
                    ->update([
                        'company_id' => $request->company_id,
                        'name' => $request->contact_name,
                        'designation' => $request->designation,
                        'updated_at' => now(),
                    ]);

                $contactId = $request->contact_id;

            } else {

                $contactId = DB::table('contact')->insertGetId([
                    'company_id' => $request->company_id,
                    'name' => $request->contact_name,
                    'designation' => $request->designation,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            /* -------------------------
            | 3. EMAILS
            --------------------------*/
            DB::table('contact_email')->where('contact_id', $contactId)->delete();

            foreach ($request->emails ?? [] as $email) {
                if ($email) {
                    DB::table('contact_email')->insert([
                        'contact_id' => $contactId,
                        'email' => $email,
                        'is_primary' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            /* -------------------------
            | 4. MOBILES
            --------------------------*/
            DB::table('contact_mobile')->where('contact_id', $contactId)->delete();

            foreach ($request->mobiles ?? [] as $mobile) {
                if ($mobile) {
                    // dd($mobile);
                    DB::table('contact_mobile')->insert([
                        'contact_id' => $contactId,
                        'mobile' => $mobile,

                        'is_primary' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $mobiledata = DB::table('contact_mobile')->where('contact_id', $contactId)->get();
            // dd($mobiledata);
            // echo "<pre>";
            // print_r($mobiledata);
            // echo "</pre>";

            /* -------------------------
            | 5. LEAD (STRICT lead_id ONLY)
            --------------------------*/
            $leadId = (int) $request->lead_id;

            $affected = DB::table('leads')
                ->where('lead_id', $leadId)
                ->update([
                    'company_id' => $request->company_id,
                    'contact_id' => $contactId,
                    'exhibition_year' => $request->exhibition_year,
                    'fascia' => $request->fascia,
                    'sales_person' => $request->sales_person,
                    'exhibitor' => $request->exhibitor,
                    'status' => $request->status ?? 'draft',
                    'updated_at' => now(),
                ]);

            if (!$affected) {
                throw new \Exception("Invalid lead_id: Lead not found.");
            }

            /* -------------------------
            | 6. LOCATIONS (REPLACE ALL)
            --------------------------*/
            DB::table('lead_locations')->where('lead_id', $leadId)->delete();

            foreach ($request->locations ?? [] as $loc) {

                if (empty($loc['location'])) {
                    continue;
                }

                DB::table('lead_locations')->insert([
                    'lead_id' => $leadId,
                    'location' => $loc['location'],
                    'stall_location' => $loc['stall_location'] ?? null,
                    'size' => $loc['size'] ?? null,
                    'amount' => $loc['amount'] ?? null,
                    'gst' => $loc['gst'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            // dd($leadId);
            DB::commit();

            // dd($leadId, True);

            return $this->getdetails($leadId, true);


            return redirect()->route('searchlead', ['id' => $leadId]);
            //     'status' => true,
            //     'message' => 'Lead finalized successfully',
            //     'lead_id' => $leadId
            // ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $databasecontroller = new DatabaseController();

        $duplicate = $databasecontroller->createduplicate(
            $request->company_id,
            $request->contact_id,
            'lead'
        );

        $duplicateData = $duplicate->getData(true);

        $unique_id = $duplicateData['new_company_id'] ?? null;
        $newContactId = $duplicateData['new_contact_id'] ?? null;

        $userdata = session()->get('user');
        $userid = $userdata->name ?? null;

        $leadId = DB::table('leads')->insertGetId([
            'company_id' => $unique_id,
            'contact_id' => $newContactId,
            'exhibitor' => $request->exhibitor,
            'sales_person' => $userid,
            'status' => 'draft',
            'payment_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $locations = $request->stall_location ?? [];

        foreach ($locations as $i => $loc) {
            DB::table('lead_locations')->insert([
                'lead_id' => $leadId,
                'location' => $loc,
                'stall_location' => $request->stall_location[$i] ?? null,
                'size' => $request->size[$i] ?? null,
                // 'grand_total' => $request->price[$i] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return view('backend.salesportal');

        // return response()->json([
        //     'status' => 'success',
        //     'lead_id' => $leadId
        // ]);
    }



}