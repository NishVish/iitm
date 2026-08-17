<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        // dd($request->all());
        $query = $request->input('q');

        // 🔐 check session
        if (!session()->has('user')) {
            return redirect('/backend')->with('error', 'Login required');
        }

        // ❌ empty search
        if (!$query) {
            return response()->json([
                'success' => true,
                'query' => '',
                'results' => []
            ]);
        }

        // 🔍 detect type
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

        $database = new DatabaseControllerApp();
        $contactId = null;
        $contactId = $database->getLatestContactId($mobile, $email);
        // dd($contactId);
        $contact_data = DB::table('contact')->where('contact_id', $contactId)->get();
        // 🧠 base query
        dd($contact_data);
        $company_data = DB::table('company_data')->where('company_id', $contact_data->company_id)->get();
        dd($company_data);
        $resultQuery = DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->where('company_data.entry_type', 'main')
            ->select(
                'contact.*',
                'company_data.*',
                'contact_email.*',
                'contact_mobile.*'
            );

        // 🎯 condition handling
        if ($contactId) {
            // exact match (email/mobile)
            $resultQuery->where('contact.contact_id', $contactId);
        } else {
            // 🔎 search by name OR company_name
            $resultQuery->where(function ($q) use ($name) {
                $q->where('contact.name', 'LIKE', "%{$name}%")
                    ->orWhere('company_data.company_name', 'LIKE', "%{$name}%");
            });
        }

        $result = $resultQuery->get();

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $result,
        ]);
    }

    public function searchleads(Request $request)
    {
        $query = $request->input('q');

        // 🔐 check session
        if (!session()->has('user')) {
            return redirect('/backend')->with('error', 'Login required');
        }

        // ❌ empty search
        if (!$query) {
            return response()->json([
                'success' => true,
                'query' => '',
                'results' => []
            ]);
        }

        // 🔍 detect type
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

        $database = new DatabaseControllerApp();
        $contactId = null;

        if ($mobile || $email) {
            $contactId = $database->getLatestContactId($mobile, $email);
        }

        // 🧠 base query
        $resultQuery = DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->where('company_data.entry_type', 'lead')
            ->select(
                'contact.*',
                'company_data.*',
                'contact_email.*',
                'contact_mobile.*'
            );

        // 🎯 condition handling
        if ($contactId) {
            // exact match (email/mobile)
            $resultQuery->where('contact.contact_id', $contactId);
        } else {
            // 🔎 search by name OR company_name
            $resultQuery->where(function ($q) use ($name) {
                $q->where('contact.name', 'LIKE', "%{$name}%")
                    ->orWhere('company_data.company_name', 'LIKE', "%{$name}%");
            });
        }

        $result = $resultQuery->get();

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $result,
        ]);
    }


}