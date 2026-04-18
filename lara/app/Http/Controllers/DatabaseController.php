<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DatabaseController extends Controller
{


    public function index()
    {


        return view("web.database");
    }

    public function getAllCompanyData($mobileNumber)
    {
        $data = DB::table('contact_mobile')
            ->join('contact', 'contact_mobile.contact_id', '=', 'contact.contact_id')
            ->join('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('contact_mobile.mobile', $mobileNumber)
            ->select(
                'contact.*',
                'company_data.*',
                'contact_mobile.mobile'
            )
            ->orderBy('contact.updated_at', 'desc')
            ->get();

        // dd($data);
        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
                'count' => 0,
                'data' => []
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data found',
            'count' => $data->count(),
            'data' => $data
        ]);
    }

    public function checkifleadexists($contactid)
    {

        $data = DB::table('leads')->where('contact_id', $contactid)->first();
        // $dataall = DB::table('leads')->get();

        // dd($data);
        echo "<pre>";
        // print_r($data);
        // print_r($dataall);
        print_r($contactid);
        print_r("Super");
        echo "</pre>";

        // if()
        return $data;
    }

    public function Updateeamilandcontact($contactid, $data)
    {

        DB::table('contact')->where('contact_id', $contactid)->update($data);
        db::table('contact_email')->where('contact_id', $contactid)->update($data);


    }
    public function getLatestCompanyDatabymobile($mobileNumber, $city = null, $returntype = null)
    {
        $query = DB::table('contact_mobile')
            ->join('contact', 'contact_mobile.contact_id', '=', 'contact.contact_id')
            ->join('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->where('company_data.entry_type', 'main')
            ->where('contact_mobile.mobile', $mobileNumber)
            ->select(
                'contact.*',
                'company_data.*',
                'contact_mobile.mobile'
            );

        if ($city) {
            $query->where('company_data.city', $city);
        }

        $data = $query->orderBy('contact.updated_at', 'desc')->first();


        if ($data) {

            if ($returntype == Null) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data found',
                    'data' => $data
                ]);
            } else {
                return $data->contact_id;
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No data found',
                'data' => null
            ]);
        }
    }

    public function getDetails($value)
    {

        dd($value);
        // 1. Try mobile
        $mobileRow = DB::table('contact_mobile')
            ->where('mobile', $value)
            ->first();

        $contact = null;

        // 2. Try email
        if (!$mobileRow) {
            $emailRow = DB::table('contact_email')
                ->where('email', $value)
                ->first();

            if ($emailRow) {
                $mobileRow = DB::table('contact_mobile')
                    ->where('contact_id', $emailRow->contact_id)
                    ->first();
            }
        }

        // 3. Try contact name
        if (!$mobileRow) {
            $contact = DB::table('contact')
                ->where('name', 'like', "%$value%")
                ->first();

            if ($contact) {
                $mobileRow = DB::table('contact_mobile')
                    ->where('contact_id', $contact->contact_id)
                    ->first();
            }
        }

        // 4. Try company name
        if (!$mobileRow) {
            $company = DB::table('company_data')
                ->where('company_name', 'like', "%$value%")
                ->first();

            if ($company) {
                $contact = DB::table('contact')
                    ->where('company_id', $company->company_id)
                    ->first();

                if ($contact) {
                    $mobileRow = DB::table('contact_mobile')
                        ->where('contact_id', $contact->contact_id)
                        ->first();
                }
            }
        }

        // ❌ nothing found
        if (!$mobileRow) {
            return response()->json([
                'mobile' => null,
                'contact' => null,
                'company' => null,
                'email' => null,
                'othercontacts' => []
            ]);
        }

        // resolve full data
        $contact = DB::table('contact')
            ->where('contact_id', $mobileRow->contact_id)
            ->first();

        $email = DB::table('contact_email')
            ->where('contact_id', $mobileRow->contact_id)
            ->first();

        $company = DB::table('company_data')
            ->where('company_id', $contact->company_id)
            ->first();

        $othercontacts = DB::table('contact_mobile')
            ->where('contact_id', $mobileRow->contact_id)
            ->get();

        return response()->json([
            'mobile' => $mobileRow,
            'contact' => $contact,
            'company' => $company,
            'email' => $email,
            'othercontacts' => $othercontacts
        ]);
    }
    public function updatedetails(request $request)
    {
        // dd($request->all());

        $leadcolumns = Schema::getColumnListing('leads');

        // dd($leadcolumns);

        return view('booking.step3', compact('leadcolumns'));


    }






}