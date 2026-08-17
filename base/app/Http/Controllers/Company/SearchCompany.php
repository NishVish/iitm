<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookingDetail;
use App\Models\EventDetail;
use App\Models\CompanyDetail;
use App\Models\DelegateAttending;
use Illuminate\Support\Facades\DB;


class SearchCompany extends Controller
{


    public function search(Request $request)
    {
        dd("Hello");


        $query = "SELECT COUNT(company_name) AS total FROM company_data";

        $result = $this->databasequery($query);

        dd($result);




        if (session('usertype') != 'admin') {
            abort(403);
        }

        $value = trim($request->input('keyword'));

        if ($value === '') {
            return response()->json([]);
        }

        $companyIds = [];

        // 1. Search company name
        $companyIds = DB::table('company_data')
            ->where('company_name', 'like', '%' . $value . '%')
            ->pluck('company_id')
            ->toArray();
        echo ($companyIds);

        echo ("Heor");



        // 2. Search contact name
        $contactCompanyIds = DB::table('contact')
            ->where('name', 'like', '%' . $value . '%')
            ->pluck('company_id')
            ->toArray();
        echo ($contactCompanyIds);
        echo ("Heor");

        $companyIds = array_merge($companyIds, $contactCompanyIds);

        // 3. Search mobile
        $mobileCompanyIds = DB::table('contact_mobile as cm')
            ->where('cm.mobile', 'like', '%' . $value . '%')
            ->pluck('cm.contact_id')
            ->toArray();

        if (!empty($mobileCompanyIds)) {
            $mobileCompanyIds = DB::table('contact')
                ->whereIn('contact_id', $mobileCompanyIds)
                ->pluck('company_id')
                ->toArray();

            $companyIds = array_merge($companyIds, $mobileCompanyIds);
        }

        // 4. Search email
        $emailContactIds = DB::table('contact_email')
            ->where('email', 'like', '%' . $value . '%')
            ->pluck('contact_id')
            ->toArray();

        if (!empty($emailContactIds)) {
            $emailContactIds = DB::table('contact')
                ->whereIn('contact_id', $emailContactIds)
                ->pluck('company_id')
                ->toArray();

            $companyIds = array_merge($companyIds, $emailContactIds);
        }

        // Remove duplicate company IDs
        $companyIds = array_unique($companyIds);

        // Nothing found
        if (empty($companyIds)) {
            return response()->json([]);
        }

        // Finally get the companies
        $companies = DB::table('company_data')
            ->whereIn('company_id', $companyIds)
            ->get();

        return response()->json($companies);
    }

}