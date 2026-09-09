<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Booking\BookingData;
use App\Http\Controllers\CRUD\GetData\GetDataController;


class CompanyController extends Controller
{


    public function index()
    {

        return view('sales.index');
    }



    public function addCompany()
    {

        return view('sales.index');
    }

    public function companydetails($companyid)
    {

        $data = new GetDataController();

        // get the data where company_id = $companyid
        $companydata = $data->companydata($companyid);
        // echo $companydata;
        $contactdata = $data->contactdata($companyid);
        $contact = $contactdata;

        $bookingdata = $data->bookingData($companyid);

        $usersdata = DB::table('users')
            ->select('name', 'id')
            ->get();
        $eventsdata = DB::table('events')
            ->select('name', 'event_id')
            ->get();

        echo '<pre>';
        print_r($companydata);
        print_r($contact);

        echo '</pre>';


        return view('sales.index', compact('companydata', 'bookingdata', 'usersdata', 'eventsdata', 'contact'));
    }

    public function search(Request $request)
    {
        $keyword = trim($request->input('keyword'));


        $query = "SELECT * 
              FROM company_data 
              WHERE company_name LIKE '%" . addslashes($keyword) . "%'";

        $companies = $this->databasequery($query);

        if (empty($companies)) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Step 2: Get all company IDs
        |--------------------------------------------------------------------------
        */
        $companyIds = collect($companies)
            ->pluck('company_id')
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Step 3: Get all contacts using company IDs
        |--------------------------------------------------------------------------
        */
        $contacts = DB::table('contact')
            ->whereIn('company_id', $companyIds)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Step 4: Get all contact IDs
        |--------------------------------------------------------------------------
        */

        $contactIds = $contacts
            ->pluck('contact_id')
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Step 5: Get all mobile numbers
        |--------------------------------------------------------------------------
        */

        $mobiles = DB::table('contact_mobile')
            ->whereIn('contact_id', $contactIds)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Step 6: Get all emails
        |--------------------------------------------------------------------------
        */

        $emails = DB::table('contact_email')
            ->whereIn('contact_id', $contactIds)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Step 7: Attach contacts, mobiles and emails to each company
        |--------------------------------------------------------------------------
        */
        $result = collect($companies)->map(function ($company) use ($contacts, $mobiles, $emails) {

            $companyContacts = $contacts
                ->where('company_id', $company->company_id)
                ->map(function ($contact) use ($mobiles, $emails) {

                    $contact->mobiles = $mobiles
                        ->where('contact_id', $contact->contact_id)
                        ->values();

                    $contact->emails = $emails
                        ->where('contact_id', $contact->contact_id)
                        ->values();

                    return $contact;
                })
                ->values();

            $company->contacts = $companyContacts;

            return $company;
        })->values();

        return view('sales.index', compact('result'));
    }


}