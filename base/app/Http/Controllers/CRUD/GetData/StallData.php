<?php

namespace App\Http\Controllers\CRUD\GetData;

use Illuminate\Support\Facades\DB;

trait StallData
{

    public function stalldatabyevent($eventid)
    {
        /*
        |--------------------------------------------------------------------------
        | Get all stalls for event
        |--------------------------------------------------------------------------
        */

        $stalls = DB::table('stall_booking_data')
            ->leftJoin(
                'events',
                'stall_booking_data.event_id',
                '=',
                'events.event_id'
            )
            ->where('stall_booking_data.event_id', $eventid)
            ->select(
                'stall_booking_data.*',

                'events.event_id as event_id',
                'events.b2b_constrain',
                'events.year',
                'events.name as event_name',
                'events.event_image',
                'events.venue_details',
                'events.total_venue_area',
                'events.stall_price',
                'events.venue_booking_details',
                'events.coordinator',
                'events.start_date',
                'events.end_date'
            )
            ->get();

        /*
        |--------------------------------------------------------------------------
        | No stalls found
        |--------------------------------------------------------------------------
        */

        if ($stalls->isEmpty()) {
            return $stalls;
        }

        /*
        |--------------------------------------------------------------------------
        | Get stall IDs
        |--------------------------------------------------------------------------
        */

        $stallIds = $stalls->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Get paid amount for each stall
        |--------------------------------------------------------------------------
        */

        $payments = DB::table('payment_records')
            ->whereIn('stall_id', $stallIds)
            ->select(
                'stall_id',
                DB::raw('SUM(amount) as paid_amount')
            )
            ->groupBy('stall_id')
            ->get()
            ->keyBy('stall_id');

        /*
        |--------------------------------------------------------------------------
        | Get delegates / contacts
        |--------------------------------------------------------------------------
        */

        $contacts = DB::table('stall_delegates as sd')
            ->leftJoin(
                'contact as c',
                'sd.contact_id',
                '=',
                'c.contact_id'
            )
            ->leftJoin(
                'contact_email as ce',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'ce.contact_id'
                    )
                        ->where('ce.is_primary', 1);
                }
            )
            ->leftJoin(
                'contact_mobile as cm',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'cm.contact_id'
                    )
                        ->where('cm.is_primary', 1);
                }
            )
            ->whereIn('sd.stall_id', $stallIds)
            ->where('sd.stall_delegate', 1)
            ->select(
                'sd.stall_id',
                'sd.contact_id as delegate_contact_id',
                'sd.stall_delegate',
                'sd.billing_contact as stall_billing_contact',

                'c.*',

                'ce.email as contact_email',
                'cm.mobile as contact_mobile'
            )
            ->get()
            ->groupBy('stall_id');

        /*
        |--------------------------------------------------------------------------
        | Add contacts + payment to each stall
        |--------------------------------------------------------------------------
        */

        $stalls->transform(function ($stall) use ($contacts, $payments) {

            // Contacts / delegates
            $stall->contacts = $contacts
                ->get($stall->id, collect())
                ->values();

            // Paid amount
            $stall->paid_amount = (float) (
                $payments->get($stall->id)->paid_amount ?? 0
            );

            return $stall;
        });

        return $stalls;
    }
    public function stalldata($bookingid)
    {
        $stalls = DB::table('stall_booking_data')
            ->leftJoin(
                'events',
                'stall_booking_data.event_id',
                '=',
                'events.event_id'
            )
            ->where(
                'stall_booking_data.booking_id',
                $bookingid
            )
            ->select(
                'stall_booking_data.*',

                'events.event_id as event_id',
                'events.b2b_constrain',
                'events.year',
                'events.name as event_name',
                'events.event_image',
                'events.venue_details',
                'events.total_venue_area',
                'events.stall_price',
                'events.venue_booking_details',
                'events.coordinator',
                'events.start_date',
                'events.end_date'
            )
            ->get();

        if ($stalls->isEmpty()) {
            return $stalls;
        }

        /*
        |--------------------------------------------------------------------------
        | Get paid amount for each stall
        |--------------------------------------------------------------------------
        */

        $stallIds = $stalls->pluck('id');

        $payments = DB::table('payment_records')
            ->where('booking_id', $bookingid)
            ->whereIn('stall_id', $stallIds)
            ->select(
                'stall_id',
                DB::raw('SUM(amount) as paid_amount')
            )
            ->groupBy('stall_id')
            ->get()
            ->keyBy('stall_id');

        // dd($payments);

        /*
        |--------------------------------------------------------------------------
        | Get contacts
        |--------------------------------------------------------------------------
        */

        $contacts = DB::table('stall_delegates as sd')
            ->leftJoin(
                'contact as c',
                'sd.contact_id',
                '=',
                'c.contact_id'
            )
            ->leftJoin(
                'contact_email as ce',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'ce.contact_id'
                    )
                        ->where('ce.is_primary', 1);
                }
            )
            ->leftJoin(
                'contact_mobile as cm',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'cm.contact_id'
                    )
                        ->where('cm.is_primary', 1);
                }
            )
            ->whereIn('sd.stall_id', $stallIds)
            ->where('sd.stall_delegate', 1)
            ->select(
                'sd.stall_id',
                'sd.contact_id as delegate_contact_id',
                'sd.stall_delegate',
                'sd.billing_contact as stall_billing_contact',

                'c.*',

                'ce.email as contact_email',
                'cm.mobile as contact_mobile'
            )
            ->get()
            ->groupBy('stall_id');


        /*
        |--------------------------------------------------------------------------
        | Add contacts + paid amount to each stall
        |--------------------------------------------------------------------------
        */

        $stalls->transform(function ($stall) use ($contacts, $payments) {

            $stall->contacts = $contacts
                ->get($stall->id, collect())
                ->values();

            // Paid amount for this stall
            $stall->paid_amount = (float) (
                $payments->get($stall->id)->paid_amount ?? 0
            );

            return $stall;
        });

        return $stalls;
    }


    public function stalldatastallid($stallId)
    {
        $stall = DB::table('stall_booking_data')
            ->leftJoin(
                'events',
                'stall_booking_data.event_id',
                '=',
                'events.event_id'
            )
            ->where('stall_booking_data.id', $stallId)
            ->select(
                'stall_booking_data.*',
                'events.event_id as event_id',
                'events.b2b_constrain',
                'events.year',
                'events.name as event_name',
                'events.event_image',
                'events.venue_details',
                'events.total_venue_area',
                'events.stall_price',
                'events.venue_booking_details',
                'events.coordinator',
                'events.start_date',
                'events.end_date'
            )
            ->first();

        if (!$stall) {
            return null;
        }

        $stall->contacts = DB::table('stall_delegates as sd')
            ->leftJoin(
                'contact as c',
                'sd.contact_id',
                '=',
                'c.contact_id'
            )
            ->leftJoin(
                'contact_email as ce',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'ce.contact_id'
                    )->where('ce.is_primary', 1);
                }
            )
            ->leftJoin(
                'contact_mobile as cm',
                function ($join) {
                    $join->on(
                        'c.contact_id',
                        '=',
                        'cm.contact_id'
                    )->where('cm.is_primary', 1);
                }
            )
            ->where('sd.stall_id', $stallId)
            ->where('sd.stall_delegate', 1)
            ->select(
                'sd.stall_id',
                'sd.contact_id as delegate_contact_id',
                'sd.stall_delegate',
                'sd.billing_contact as stall_billing_contact',
                'c.*',
                'ce.email as contact_email',
                'cm.mobile as contact_mobile'
            )
            ->get();

        $stall->paid_amount = (float) (
            DB::table('payment_records')
                ->where('stall_id', $stallId)
                ->sum('amount')
        );

        return $stall;
    }
}