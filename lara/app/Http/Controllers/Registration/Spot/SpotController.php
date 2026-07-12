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
        if ($request->registertype == 'Trade') {

            $db = DB::connection('special_db');

            // Generate unique company ID (10 characters)
            do {
                $companyId = 'COMP' . rand(100000, 999999);
            } while (
                $db->table('tradevisitor')
                    ->where('company_id', $companyId)
                    ->exists()
            );

            foreach ($request->delegates as $delegate) {

                $db->table('tradevisitor')->insert([
                    'person_key' => uniqid('TRADE_'),
                    'name' => $delegate['name'] ?? null,
                    'designation' => $delegate['designation'] ?? null,

                    // Same company details for every delegate
                    'company_name' => $request->company_name,
                    'company_id' => $companyId,
                    'category' => 'Trade',

                    'address' => $request->address,
                    'city' => $request->city,
                    'pin' => $request->pincode,
                    'state' => $request->state,

                    // Delegate details
                    'mobile' => $delegate['mobile'] ?? null,
                    'email' => $delegate['email'] ?? null,

                    'created_at' => now(),
                ]);
            }
            $data = [
                'status' => true,
                'company_id' => $companyId,
                'company_name' => $request->company_name,
                'delegates' => collect($request->delegates)->map(function ($delegate) {
                    return [
                        'name' => $delegate['name'] ?? null,
                        'designation' => $delegate['designation'] ?? null,
                        'mobile' => $delegate['mobile'] ?? null,
                        'email' => $delegate['email'] ?? null,
                    ];
                }),
                'message' => 'Trade visitors registered successfully'
            ];

            return view('registration.spot.response', compact('data'));
        }
    }



}