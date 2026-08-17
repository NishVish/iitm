<?php

namespace App\Http\Controllers\Registration\Spot;
use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class SpotController extends Controller
{



    // CONTROLLER (FIX: keep data but DO NOT reuse globally for both cities)
// CONTROLLER (RETURN DATA GROUPED BY CITY)

    public function index()
    {

        return view('registration.spot.index');

    }
    public function store(Request $request)
    {
        // dd($request->all());

        $db = DB::connection('special_db');

        // Decide table and category
        if ($request->registertype == 'Trade') {
            $table = 'tradevisitor';
            $category = 'Trade';
        } else {
            $table = 'exhibitor';
            $category = 'Exhibitor';
        }

        $delegatesData = [];

        foreach ($request->delegates as $delegate) {

            // Generate unique person_key
            do {
                $personKey = strtoupper($category) . '_' . strtoupper(uniqid());
            } while (
                $db->table($table)
                    ->where('person_key', $personKey)
                    ->exists()
            );

            $db->table($table)->insert([
                'person_key' => $personKey,
                'name' => $delegate['name'] ?? null,
                'designation' => $delegate['designation'] ?? null,

                'company_name' => $request->company_name,

                'address' => $request->address,
                'city' => $request->city,
                'pin' => $request->pincode,
                'state' => $request->state,

                'mobile' => $delegate['mobile'] ?? null,
                'email' => $delegate['email'] ?? null,

                'created_at' => now(),
            ]);

            // Store data for response
            $delegatesData[] = [
                'person_key' => $personKey,
                'name' => $delegate['name'] ?? null,
                'designation' => $delegate['designation'] ?? null,
                'mobile' => $delegate['mobile'] ?? null,
                'email' => $delegate['email'] ?? null,
            ];
        }

        $data = [
            'status' => true,
            'company_name' => $request->company_name,
            'register_type' => $category,
            'delegates' => $delegatesData,
            'message' => $category . ' registered successfully',
        ];

        dd($data);
        return view('registration.spot.response', compact('data'));
    }
}