<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Str;
class Save extends Controller
{
    public function store(array $data)
    {

        $companyid = 'COMP-' .
            now()->format('Ymd') .
            '-' .
            strtoupper(Str::random(6));
        DB::table('company_data')->insert([

            /*
             * ---------------------------------------------------------
             * COMPANY
             * ---------------------------------------------------------
             */
            'entry_type' => "online_registration",

            'company_id' => $companyid,
            'database_name' => "Online",

            'outbound' => $data['outbound'] ?? 0,

            'company_name' => $data['organisation']
                ?? $data['company_name']
                ?? '',


            /*
             * ---------------------------------------------------------
             * GENERIC BUSINESS CLASSIFICATION
             * ---------------------------------------------------------
             */

            'category' => $data['company_category'] ?? null,

            'business_type' => $data['business_type'] ?? null,


            'business_volume' => isset($data['business_volume'])
                && $data['business_volume'] !== ''
                ? (int) $data['business_volume']
                : null,

            'business_capacity' => isset($data['business_capacity'])
                && $data['business_capacity'] !== ''
                ? (int) $data['business_capacity']
                : null,

            'business_description' => $data['business_description']
                ?? null,



            /*
             * ---------------------------------------------------------
             * COMPANY ADDRESS
             * ---------------------------------------------------------
             */

            'address' => $data['address'] ?? null,

            'city' => $data['city'] ?? null,

            'pincode' => $data['pincode'] ?? null,

            'state' => $data['state'] ?? null,

            'country' => $data['country'] ?? null,

            'website' => $data['website'] ?? null,

            'phone' => $data['phone']
                ?? $data['mobile']
                ?? null,


            /*
             * ---------------------------------------------------------
             * EXISTING COMPANY DATA
             * ---------------------------------------------------------
             */

            'gst_number' => $data['gst_number'] ?? null,

            'sales_person' => $data['sales_person'] ?? null,

            'active_inactive' => $data['active_inactive']
                ?? 'active',

            'last_confirmed_at' => $data['last_confirmed_at'] ?? null,

            'session' => $data['session'] ?? 0,

            'cross_validation' => $data['cross_validation'] ?? 0,

            'last_comments' => $data['last_comments'] ?? null,

            'second_last_comments' => $data['second_last_comments']
                ?? null,

            'updated_by' => $data['updated_by'] ?? null,

            'second_last_comments_updated_by' =>
                $data['second_last_comments_updated_by'] ?? null,


            'pin' => $data['pin'] ?? null,

            'travel_segments' => $data['travel_segments'] ?? null,

            'meet_profiles' => $data['meet_profiles'] ?? null,

            'meet_regions' => $data['meet_regions'] ?? null,

            'interested_states' => $data['interested_states'] ?? null,

            'branch_offices' => $data['branch_offices'] ?? null,

            'total_staff' => $data['total_staff'] ?? null,

            'association_membership' =>
                $data['association_membership'] ?? null,

        ]);

        return $companyid;




    }
}

