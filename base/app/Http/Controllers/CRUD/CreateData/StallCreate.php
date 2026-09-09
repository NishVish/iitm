<?php

namespace App\Http\Controllers\CRUD\CreateData;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait StallCreate
{
    public function createStall($companyid)
    {

        // dd('hello');
        request()->validate([
            'event_id' => 'required',
        ]);

        // Generate Unique Booking ID
        $bookingId = 'BK' . strtoupper(Str::random(10));

        // Save booking
        DB::table('booking_record')->insert([
            'booking_id' => $bookingId,
            'company_id' => request('company_id', $companyid),
            'sales_id' => '1',
        ]);


        dd($bookingId);


        return $bookingId;
    }
}