<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        // Correct way to return a Blade view
        return view('booking.index');
    }

    public function searchleadapi($value)
    {

        $latestdata = $this->getLatestCompanyData($value);
        // dd($latestdata);
        $contact_id = $latestdata->contact_id;
        $contact = DB::table('contact')->where('contact_id', $contact_id)->first();
        $numbers = DB::table('contact_mobile')->where('mobile', $value)->get();
        $lead = DB::table('leads')->where('contact_id', $contact_id)->first();
        $leadloaction = DB::table('lead_locations')->where('lead_id', $lead->lead_id)->get();
        // dd($lead);
        if ($lead) {
            echo "<pre>";
            print_r($numbers);
            print_r($contact);

            print_r($leadloaction);
            print_r($lead);
            echo "</pre>";

            return view('booking.leadform', compact('lead', 'leadloaction'));
        } else {
            return view('booking.leadform');
        }
    }


    public function getLatestCompanyData($mobileNumber)
    {
        // 1. Find the contact associated with this mobile number
        // Joining contact and company tables to get the full picture
        $data = DB::table('contact_mobile')
            ->join('contact', 'contact_mobile.contact_id', '=', 'contact.contact_id')
            ->join('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('contact_mobile.mobile', $mobileNumber)
            ->select(
                'contact.*',
                'company_data.*',
                'contact_mobile.mobile'
            )
            // 2. Order by updated_at or created_at to get the "latest"
            ->orderBy('contact.updated_at', 'desc')
            ->first();

        return $data;
    }


    public function leadsearchpage()
    {

        echo "hello";

        return view('booking.searchlead');
    }





    public function getDetails($value)
    {

        // dd($value);
        $value = trim($value, '"');

        $filters = [];

        // -----------------------------
        // Parse key=value OR default mobile
        // -----------------------------
        if (str_contains($value, '=')) {

            $parts = explode(',', $value);

            foreach ($parts as $part) {
                [$key, $val] = array_pad(explode('=', $part, 2), 2, null);

                if ($key && $val) {
                    $filters[$key] = $val;
                }
            }

        } else {
            $filters['mobile'] = $value;
        }

        // -----------------------------
        // Find contact_id (ALL CASES)
        // -----------------------------
        $contactId = null;

        if (!empty($filters['contact_id'])) {
            $contactId = $filters['contact_id'];
        }

        if (!$contactId && !empty($filters['mobile'])) {
            $mobile = DB::table('contact_mobile')
                ->where('mobile', $filters['mobile'])
                ->first();

            $contactId = $mobile->contact_id ?? null;
        }

        if (!$contactId && !empty($filters['company_id'])) {
            $contact = DB::table('contact')
                ->where('company_id', $filters['company_id'])
                ->first();

            $contactId = $contact->contact_id ?? null;
        }

        if (!$contactId) {
            return response()->json([
                'mobile' => null,
                'contact' => null,
                'company' => null,
                'email' => null
            ]);
        }

        // -----------------------------
        // Fetch full details
        // -----------------------------
        $contact = DB::table('contact')->where('contact_id', $contactId)->first();
        $mobile = DB::table('contact_mobile')->where('contact_id', $contactId)->first();
        $email = DB::table('contact_email')->where('contact_id', $contactId)->first();
        $company = DB::table('company_data')->where('company_id', $contact->company_id)->first();

        return response()->json([
            'mobile' => $mobile,
            'contact' => $contact,
            'company' => $company,
            'email' => $email,
            'filters_used' => $filters
        ]);
    }
    public function leadform(request $request)
    {
        // dd($request->all());

        $leadcolumns = Schema::getColumnListing('leads');
        $leadlocation = Schema::getColumnListing('lead_locations');

        // dd($leadlocation);

        return view('booking.leadform', compact('leadcolumns', 'leadlocation'));


    }

    public function saveleaddetails(Request $request)
    {
        dd($request->all());

        // 3. Get details for the review page
        // $companydata = $this->getDetails("contact_id=" . $request->contact_id);
        // $leaddata = DB::table('leads')->where('lead_id', $leadId)->first();
        // $location = DB::table('lead_locations')->where('lead_id', $leadId)->get();
        return view('booking.review', compact('leaddata', 'companydata', 'location'));
    }





}