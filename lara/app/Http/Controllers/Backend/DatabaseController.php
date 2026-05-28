<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DatabaseController as DatabaseControllerApp;
use Illuminate\Support\Facades\Route; // ✅ ADD THIS

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


    public function categorizedRoutes()
    {
        $groups = [];

        foreach (Route::getRoutes() as $route) {

            $uri = $route->uri();

            // Skip system routes
            if (str_contains($uri, '_ignition') || str_contains($uri, 'sanctum')) {
                continue;
            }

            // 🎯 dynamic group name = first segment of URI
            $segments = explode('/', $uri);
            $group = $segments[0] ?? 'root';

            // normalize empty or "/" routes
            if ($group === '' || $group === null) {
                $group = 'root';
            }

            // route name fallback
            $name = $route->getName();
            if (!$name) {
                $name = ucwords(str_replace(['/', '-', '_'], ' ', $uri));
            }

            // init group if not exists
            if (!isset($groups[$group])) {
                $groups[$group] = [];
            }

            $groups[$group][] = [
                'name' => $name,
                'uri' => $uri,
                'url' => url($uri),
            ];
        }

        return response()->json($groups);
    }
    public function getcompanydetail($company_id)
    {
        $company_detail = DB::table('company_data')
            ->where('company_id', $company_id)
            ->first();
        return response()->json($company_detail);
    }

    public function runQuery(Request $request)
    {
        try {

            $sql = $request->input('sql') ?? '';

            if (!$sql) {
                return response()->json([
                    'success' => false,
                    'error' => 'SQL is empty'
                ], 400);
            }



            $result = DB::select($sql);
            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getDatabaseSchema()
    {
        $database = DB::getDatabaseName();

        // Pull EVERYTHING in one go. Much faster than looping queries.
        $rows = DB::select("
        SELECT 
            TABLE_NAME,
            COLUMN_NAME,
            DATA_TYPE,
            CHARACTER_MAXIMUM_LENGTH,
            COLUMN_KEY,
            IS_NULLABLE,
            COLUMN_DEFAULT
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ?
        ORDER BY TABLE_NAME, ORDINAL_POSITION
    ", [$database]);

        // Group the flat rows into the nested structure you want
        $result = collect($rows)->groupBy('TABLE_NAME')->map(function ($columns, $tableName) {
            return [
                'Table' => $tableName,
                'Columns' => $columns->map(function ($col) {
                    return [
                        'Column Name' => $col->COLUMN_NAME,
                        'Type' => $col->DATA_TYPE,
                        'Max Length' => $col->CHARACTER_MAXIMUM_LENGTH,
                        'Primary Key' => ($col->COLUMN_KEY === 'PRI') ? 'Yes' : 'No',
                        'Nullable' => ($col->IS_NULLABLE === 'YES') ? 'Yes' : 'No',
                        'Default' => $col->COLUMN_DEFAULT,
                    ];
                })
            ];
        })->values(); // Reset keys to make it a clean array for JSON

        return response()->json($result);
    }
    public function allRoutes()
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'url' => url($route->uri()),
            ];
        });

        return response()->json($routes);
    }
    public function getcompanybyentrytype($entrytype)
    {
        $company_detail = DB::table('company_data')
            ->where('entry_type', $entrytype)
            ->get();
        return response()->json($company_detail);
    }

    public function databaseportal()
    {
        return view('backend.data.index');
    }
    public function otherregistration()
    {
        $company_detail = DB::table('company_data')
            ->leftjoin('contact', 'company_data.company_id', '=', 'contact.company_id')
            ->leftjoin('contact_mobile', 'contact.contact_id', '=', 'contact_mobile.contact_id')
            ->leftjoin('contact_email', 'contact.contact_id', '=', 'contact_email.contact_id')
            ->where('category', 'other')
            ->where('entry_type', 'online_registration')
            ->get();

        return response()->json($company_detail);
    }

    public function updateCategory($companyid, $contactid, $email, $category)
    {



        DB::table('company_data')
            ->where('company_id', $companyid)
            ->update([
                'category' => $category,
            ]);


    }

    public function rejectCompany($companyid, $contactid, $email)
    {
        DB::table('company_data')
            ->where('company_id', $companyid)
            ->update([
                'category' => 'rejected',
            ]);
        return redirect()->back();
    }
}