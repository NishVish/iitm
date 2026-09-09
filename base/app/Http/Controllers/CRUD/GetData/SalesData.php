<?php

namespace App\Http\Controllers\CRUD\GetData;

use Illuminate\Support\Facades\DB;

trait SalesData
{
    public function salesData($salesId = null, $eventId = null)
    {
        $query = DB::table('booking_record')
            ->leftJoin(
                'stall_booking_data',
                'booking_record.booking_id',
                '=',
                'stall_booking_data.booking_id'
            )
            ->select(
                'booking_record.*',
                'stall_booking_data.id as stall_booking_data_id',
                'stall_booking_data.event_id as stall_event_id',
                'stall_booking_data.stall_size',
                'stall_booking_data.stall_location',
                'stall_booking_data.stall_type',
                'stall_booking_data.fascia',
                'stall_booking_data.certificate',
                'stall_booking_data.branding',
                'stall_booking_data.discount_code',
                'stall_booking_data.discount_amount',
                'stall_booking_data.final_price',
                'stall_booking_data.original_amount',
                'stall_booking_data.gst_amount',
                'stall_booking_data.due_amount'
            );

        if (!empty($salesId)) {
            $query->where('booking_record.sales_id', $salesId);
        }

        if (!empty($eventId)) {
            $query->where('booking_record.event_id', $eventId);
        }

        return $query->get();
    }
}