<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class BadgeController extends Controller
{
    public function badgepreview()
    {
        $alldata = [
            'contactName' => 'John Doe',
            'companyName' => 'ABC Technologies',
            'email' => 'john@example.com',
            'mobile' => '9876543210'
        ];

        $event = [
            [
                'name' => 'IITM Kolkata',
                'venue_details' => 'Kolkata Exhibition Center'
            ]
        ];

        $badge_color = '#a42627';

        return view('badge.badge', compact('alldata', 'event', 'badge_color'));
    }

    public function downloadBadge(Request $request)
    {
        // $email = $request->email;
        // $mobile = $request->mobile;
        $mobile = 7909075199;
        $email = 'nishwakarma3@gmail.com';

        // dd($mobile,$email);
        $database = new DatabaseController();

        $contactid = DB::table('contact_email as e')
            ->join('contact_mobile as m', 'e.contact_id', '=', 'm.contact_id')
            ->where('e.email', $email)
            ->where('m.mobile', $mobile)
            ->where('e.is_primary', 1)
            ->where('m.is_primary', 1)
            ->value('e.contact_id');

        // fallback if not found
        if (!$contactid) {
            $contactid = DB::table('contact_mobile')
                ->where('mobile', $mobile)
                ->value('contact_id');
        }// dd($contactid);
        $contactdata = DB::table('contact')
            ->where('contact_id', $contactid)
            ->first();

        $companyData = null;
        if (!empty($contactdata->company_id)) {
            $companyData = DB::table('company_data')
                ->where('company_id', $contactdata->company_id)
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

        return view('web.registration.successpage.badge', compact('email', 'mobile'));
    }



    public function generatebadge($company_id, $contact_id, $db)
    {
        // $company_id = 'CMP_69e8b4a410b8b';

        // dd($company_id, $contact_id, $db);

        $contactdatafromcompanyid = DB::table('contact')
            ->where('company_id', $company_id)
            ->first();
        // dd($contactdatafromcompanyid);
        $comapnydata = DB::table('company_data')
            ->where('company_id', $company_id)
            ->first();

        $venue = null;
        $all_dates = [];
        $eventname = $db;

        // -----------------------------
        // EVENT PARSING (NAME + YEAR)
        // -----------------------------
        $parts = explode('-', $db);
        $year = array_pop($parts);
        $name = implode(' ', $parts);

        $eventdetails = DB::table("events")
            ->where('name', $name)
            ->where('year', $year)
            ->first();

        // dd($contactdatafromcompanyid, $comapnydata, $db, $parts, $year, $name, $eventdetails);

        if (!$eventdetails) {
            return view('web.registration.fail');
        }

        // ✅ VALIDATION (rebuild and compare)
        $expected = trim($eventdetails->name . ' ' . $eventdetails->year);
        $normalizedDb = strtolower(str_replace('-', ' ', trim($db)));
        $normalizedExpected = strtolower(trim($eventdetails->name . ' ' . $eventdetails->year));

        if (
            !$eventdetails ||
            $normalizedDb !== $normalizedExpected ||
            !$contactdatafromcompanyid ||
            !$comapnydata
        ) {
            return view('web.registration.fail');
        }
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

        // -----------------------------
        // CONTACT DATA SAFETY
        // -----------------------------
        $contactdata = DB::table('contact')
            ->where('contact_id', $contact_id)
            ->first();

        $companydata = DB::table('company_data')
            ->where('company_id', $company_id)
            ->first();

        // fallback values (IMPORTANT to avoid crash)
        $contactName = $contactdatafromcompanyid->name ?? '';
        $companyName = $companydata->company_name ?? '';

        $email = $contactdatafromcompanyid->email ?? 'marketing1@iitmindia.com';
        $mobile = $contactdatafromcompanyid->mobile ?? '7909075199';

        // -----------------------------
        // FINAL DATA ARRAY
        // -----------------------------
        $data = [
            'company_id' => $company_id,
            'contact_id' => $contact_id,

            'contactName' => $contactName,
            'companyName' => $companyName,

            'email' => $email,
            'mobile' => $mobile,

            'eventname' => $eventname,
            'all_dates' => $all_dates,
            'venue' => $venue,

            'emailpage' => false,
            'databasename' => $db,
            'print' => true,
            'preview' => true,
        ];

        // $data['emailpage'] = true;
        $nosuccespage = true;

        return view('web.registration.success', compact('data', 'nosuccespage'));
    }
}