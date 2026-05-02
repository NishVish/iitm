<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;
use App\Http\Controllers\Backend\DatabaseController as BackendDatabaseController;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if (!session()->has('user')) {
            return redirect('/backend')->with('error', 'Login required');
        }

        $query = trim($request->input('q', ''));

        if (empty($query)) {
            return response()->json(['success' => true, 'query' => '', 'results' => []]);
        }

        [$email, $mobile, $name] = $this->classifyQuery($query);

        $results = $this->fetchResults($email, $mobile, $name);

        if ($results->isEmpty() && ($email || $mobile)) {
            $this->handleMissingContact($email, $mobile);
            $results = $this->fetchResults($email, $mobile, $name);
        }

        return response()->json(['success' => true, 'query' => $query, 'results' => $results]);
    }

    private function classifyQuery(string $query): array
    {
        if (filter_var($query, FILTER_VALIDATE_EMAIL)) {
            return [$query, null, null]; // [email, mobile, name]
        }

        if (is_numeric($query)) {
            return [null, $query, null];
        }

        return [null, null, $query];
    }

    private function buildBaseQuery(): \Illuminate\Database\Query\Builder
    {
        return DB::table('contact')
            ->leftJoin('company_data', 'contact.company_id', '=', 'company_data.company_id')
            ->leftJoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->leftJoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->where('company_data.entry_type', 'main')
            ->select('contact.*', 'company_data.*', 'contact_email.*', 'contact_mobile.*');
    }

    private function fetchResults(?string $email, ?string $mobile, ?string $name)
    {
        $query = $this->buildBaseQuery();

        if ($email) {
            $query->where('contact_email.email', $email);
        } elseif ($mobile) {
            $query->where('contact_mobile.mobile', $mobile);
        } else {
            $query->where(function ($q) use ($name) {
                $q->where('contact.name', 'LIKE', "%{$name}%")
                    ->orWhere('company_data.company_name', 'LIKE', "%{$name}%");
            });
        }

        return $query->get();
    }

    private function handleMissingContact(?string $email, ?string $mobile): void
    {
        $database = new DatabaseControllerApp();
        $contactId = $database->getLatestContactId($mobile, $email);

        if (!$contactId) {
            return;
        }

        $companyId = DB::table('contact')
            ->where('contact_id', $contactId)
            ->value('company_id');

        if ($companyId) {
            (new BackendDatabaseController())->createduplicate($companyId, $contactId, 'main');
        }
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