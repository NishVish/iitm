<?php

namespace App\Http\Controllers\Backend\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\DatabaseController;
use Illuminate\Support\Facades\DB;
use PhpOption\None;

class LeadController extends Controller
{
    public function index()
    {

        return view('backend.sales.index');
    }

    public function allleads()
    {
        $userdata = session()->get('user');
        $userid = $userdata->name;

        $allleads = DB::table('leads')
            ->where('sales_person', $userid)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $allleads
        ]);
    }
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
                'price' => $request->price[$i] ?? 0,
                'gst_amount' => 0,
                'discount_amount' => 0,
                'grand_total' => $request->price[$i] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'lead_id' => $leadId
        ]);
    }

    public function leadsdetails(Request $request, $id, $review = false)
    {
        $bookingid = $request->id;
        $mobile = $request->mobile;

        // 1. Get lead with contact
        $lead = DB::table('leads')
            ->where('lead_id', $bookingid)
            ->first();

        if (!$lead) {
            abort(404, 'Booking not found');
        }

        // 2. Check mobile against contact_mobile table
        $contactMobile = DB::table('contact_mobile')
            ->where('contact_id', $lead->contact_id)
            ->where('mobile', $mobile)
            ->first();

        if (!$contactMobile) {
            abort(403, 'Mobile number not matched');
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
        return $this->getdetails($id, false, true, );

    }


    public function getdetails($id, $review)
    {
        // dd($id, $review);
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
        $leadinfo = DB::table('leads as l')
            ->leftJoin('lead_locations as ll', 'l.lead_id', '=', 'll.lead_id')
            ->where('l.lead_id', $id)
            ->first();
        // dd($leadinfo);
        $company = DB::table('company_data')->where('company_id', $lead->company_id)->first();
        $contact = DB::table('contact')->where('contact_id', $lead->contact_id)->first();
        // Emails
        $emails = DB::table('contact_email')
            ->where('contact_id', $lead->contact_id ?? 0)
            ->get();

        // Mobiles
        $mobiles = DB::table('contact_mobile')
            ->where('contact_id', $lead->contact_id ?? 0)
            ->get();

        // Stall / Location Details
        $locations = DB::table('lead_locations')
            ->where('lead_id', $id)
            ->get();

        // Company Source (Event Info)
        $sources = DB::table('company_sources')
            ->where('company_id', $lead->company_id ?? '')
            ->get();

        if ($review) {
            return view('booking.review', compact(
                'lead',
                'emails',
                'mobiles',
                'locations',
                'sources',
                'company',
                'contact',
                'leadinfo'
            ));
        }
        return view('booking.index', compact(
            'lead',
            'emails',
            'mobiles',
            'locations',
            'sources',
            'company',
            'contact',
            'leadinfo'
        ));



    }


    public function finalizelead(Request $request)
    {
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
                    'phone' => $request->phone,
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
                    DB::table('contact_mobile')->insert([
                        'contact_id' => $contactId,
                        'mobile' => $mobile,
                        'is_primary' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

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
                    'booking_form' => $request->booking_form,
                    'status' => $request->status ?? 'draft',
                    'payment_status' => $request->payment_status ?? 'pending',
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
                    'price' => $loc['price'] ?? 0,
                    'gst_amount' => $loc['gst_amount'] ?? 0,
                    'discount_amount' => $loc['discount_amount'] ?? 0,
                    'grand_total' => $loc['grand_total'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

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
                'price' => $request->price[$i] ?? 0,
                'gst_amount' => 0,
                'discount_amount' => 0,
                'grand_total' => $request->price[$i] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'lead_id' => $leadId
        ]);
    }



}