<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{


    public function index()
    {

        return view('company.index');
    }

    public function search(Request $request)
    {
        $keyword = trim($request->input('keyword'));

        /*
        |--------------------------------------------------------------------------
        | Step 1: Search company_data ONLY
        |--------------------------------------------------------------------------
        */
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

        return view('booking.selectcompany', compact('result'));
    }


}