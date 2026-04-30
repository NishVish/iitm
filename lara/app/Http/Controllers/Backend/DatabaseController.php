<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;

class DatabaseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // dd($query);
        // 🔐 check session
        if (!session()->has('user')) {
            return redirect('/backend')->with('error', 'Login required');
        }

        // ❌ empty search
        if (!$query) {
            return view('backend.search', [
                'results' => [],
                'query' => ''
            ]);
        }

        // 🔍 detect type (email / phone / name)
        $email = null;
        $mobile = null;
        $name = null;

        if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
            $email = $query;
        } elseif (is_numeric($query)) {
            $mobile = $query;
        } else {
            $name = $query;
        }

        // 📦 use your DatabaseController
        $database = new DatabaseControllerApp();

        $contactId = null;

        if ($mobile || $email) {

            $contactId = $database->getLatestContactId($mobile, $email);
            // dd($mobile, $email, $contactId);
        }


        $result = DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->where('contact.contact_id', $contactId)
            ->select(
                'contact.*',
                'company_data.*',
                'contact_email.*',
                'contact_mobile.*'
            )
            ->get();
        $leads = DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')

            // ✅ leads table
            ->leftJoin('leads', 'contact.contact_id', '=', 'leads.contact_id')

            // ✅ lead locations table
            ->leftJoin('lead_locations', 'leads.lead_id', '=', 'lead_locations.lead_id')

            ->where('contact.contact_id', $contactId)
            ->where('company_data.entry_type', 'leads')

            ->select(
                // contact
                'contact.contact_id',
                'contact.name',

                // company
                'company_data.company_id',
                'company_data.company_name',
                'company_data.entry_type',

                // email/mobile
                'contact_email.email',
                'contact_mobile.mobile',

                // leads
                'leads.lead_id',
                'leads.status',
                'leads.payment_status',
                'leads.fascia',
                'leads.exhibition_year',

                // lead_locations
                'lead_locations.location_id',
                'lead_locations.location',
                'lead_locations.stall_location',
                'lead_locations.size',
                'lead_locations.price',
                'lead_locations.gst_amount',
                'lead_locations.discount_amount',
                'lead_locations.grand_total'
            )
            ->get();
        // dd($leads);

        // $salesPerson = session('user.name');
        // dd($salesPerson);

        return view('backend.index', [
            'results' => $result,
            'leads' => $leads,
            'query' => $query,
        ]);


    }

    public function createduplicate($companyid, $contactid, $type)
    {
        // Get existing company
        $oldCompanydata = DB::table('company_data')
            ->where('company_id', $companyid)
            ->first();

        // Get contact
        $contact = DB::table('contact')
            ->where('contact_id', $contactid)
            ->first();

        $contactMobile = DB::table('contact_mobile')
            ->where('contact_id', $contactid)
            ->first();

        $contactEmail = DB::table('contact_email')
            ->where('contact_id', $contactid)
            ->first();

        if (!$oldCompanydata) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        // Check if any change needed (you can adjust logic)
        $isChanged = true; // since no request, assume duplicate flow always creates new

        if ($isChanged) {

            $unique_id = 'CMP_' . uniqid();
            $databasenew = "Online Registration " . date('Y');

            // 🔵 Create new company
            DB::table('company_data')->insert([
                'company_id' => $unique_id,
                'company_name' => $oldCompanydata->company_name,
                'city' => $oldCompanydata->city,
                'state' => $oldCompanydata->state,
                'pincode' => $oldCompanydata->pincode,
                'country' => $oldCompanydata->country,
                'subcategory' => $oldCompanydata->subcategory,
                'category' => $oldCompanydata->category,
                'address' => $oldCompanydata->address,
                'website' => $oldCompanydata->website,
                'branch_offices' => $oldCompanydata->branch_offices,
                'total_staff' => $oldCompanydata->total_staff,
                'travel_segments' => $oldCompanydata->travel_segments,
                'meet_profiles' => $oldCompanydata->meet_profiles,
                'meet_regions' => $oldCompanydata->meet_regions,
                'interested_states' => $oldCompanydata->interested_states,
                'entry_type' => $type,
                'cross_validation' => 0,
                'database_name' => $databasenew,
                'active_inactive' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 🔵 Create new contact
            $newContactId = DB::table('contact')->insertGetId([
                'company_id' => $unique_id,
                'name' => $contact->name ?? null,
                'designation' => $contact->designation ?? null,
                'created_at' => now()
            ]);

            // 🔵 Copy mobile
            if ($contactMobile) {
                DB::table('contact_mobile')->insert([
                    'contact_id' => $newContactId,
                    'mobile' => $contactMobile->mobile,
                    'is_primary' => 1,
                    'created_at' => now()
                ]);
            }

            // 🔵 Copy email
            if ($contactEmail) {
                DB::table('contact_email')->insert([
                    'contact_id' => $newContactId,
                    'email' => $contactEmail->email,
                    'is_primary' => 1,
                    'created_at' => now()
                ]);
            }

            // 🔵 Company source
            DB::table('company_sources')->insert([
                'company_id' => $unique_id,
                'notes' => "Lead Generation " . $companyid . " - " . date('Y'),
                'event_date' => now()
            ]);

            return response()->json([
                'message' => 'Duplicate created successfully',
                'new_company_id' => $unique_id,
                'new_contact_id' => $newContactId
            ]);
        }

        return response()->json(['message' => 'No action taken']);
    }
}