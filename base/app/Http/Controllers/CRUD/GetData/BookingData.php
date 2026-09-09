<?php

namespace App\Http\Controllers\CRUD\GetData;

use Illuminate\Support\Facades\DB;

trait BookingData
{
    public function bookingData($companyid)
    {
        // Get booking records
        $bookings = DB::table('booking_record')
            ->where('booking_record.company_id', $companyid)
            ->select('booking_record.*')
            ->get();

        // Get all booking IDs
        $bookingIds = $bookings
            ->pluck('booking_id')
            ->unique()
            ->values();

        // Get ALL stall data
        $stalls = DB::table('stall_booking_data')
            ->whereIn('booking_id', $bookingIds)
            ->get()
            ->groupBy('booking_id');

        // Get event IDs from stall_booking_data
        $eventIds = $stalls
            ->flatten()
            ->pluck('event_id')
            ->filter()
            ->unique()
            ->values();

        // Get ALL event data
        $events = DB::table('events')
            ->whereIn('event_id', $eventIds)
            ->get()
            ->keyBy('event_id');

        // Attach stalls to each booking
        foreach ($bookings as $booking) {

            $booking->stalls = $stalls
                ->get($booking->booking_id, collect())
                ->values();

            // Attach event columns directly to each stall
            foreach ($booking->stalls as $stall) {

                $event = $events->get($stall->event_id);

                if ($event) {
                    foreach ((array) $event as $key => $value) {

                        // Avoid overwriting stall columns
                        if (!property_exists($stall, $key)) {
                            $stall->{$key} = $value;
                        }
                    }
                }
            }
        }

        if ($bookings->isEmpty()) {
            return false;
        }

        return $bookings;
    }

    public function bookingDatawithbookingid($booking_id)
    {
        $bookingdata = DB::table('booking_record')

            ->where('booking_record.booking_id', $booking_id)

            ->leftJoin(
                'stall_booking_data',
                'booking_record.booking_id',
                '=',
                'stall_booking_data.booking_id'
            )

            ->leftJoin(
                'events',
                'stall_booking_data.event_id',
                '=',
                'events.event_id'
            )

            ->select(
                // =========================
                // Booking Record
                // =========================
                'booking_record.*',

                // =========================
                // Event
                // =========================
                'events.event_id as event_id',
                'events.b2b_constrain',
                'events.year as event_year',
                'events.name as event_name',
                'events.event_image',
                'events.venue_details',
                'events.total_venue_area',
                'events.stall_price',
                'events.venue_booking_details',
                'events.coordinator',
                'events.start_date as event_start_date',
                'events.end_date as event_end_date',
                'events.created_at as event_created_at',
                'events.updated_at as event_updated_at',

                // =========================
                // Stall Booking
                // =========================
                'stall_booking_data.id as stall_id',
                'stall_booking_data.booking_id as stall_booking_id',
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
                'stall_booking_data.due_amount',
                'stall_booking_data.created_at as stall_created_at',
                'stall_booking_data.updated_at as stall_updated_at'
            )
            ->get();

        if ($bookingdata->isEmpty()) {
            return [];
        }

        // First row contains common booking information
        $first = $bookingdata->first();

        // =========================
        // Booking Data
        // =========================
        $booking = collect($first)->except([
            // Event fields
            'event_id',
            'b2b_constrain',
            'event_year',
            'event_name',
            'event_image',
            'venue_details',
            'total_venue_area',
            'stall_price',
            'venue_booking_details',
            'coordinator',
            'event_start_date',
            'event_end_date',
            'event_created_at',
            'event_updated_at',

            // Stall fields
            'stall_id',
            'stall_booking_id',
            'stall_event_id',
            'stall_size',
            'stall_location',
            'stall_type',
            'fascia',
            'certificate',
            'branding',
            'discount_code',
            'discount_amount',
            'final_price',
            'original_amount',
            'gst_amount',
            'due_amount',
            'stall_created_at',
            'stall_updated_at',
        ])->toArray();

        // =========================
        // Stalls + Event Data
        // =========================
        $booking['stalls'] = $bookingdata
            ->filter(function ($item) {
                return !is_null($item->stall_id);
            })
            ->map(function ($item) {
                return [

                    // Stall basic data
                    'stall_id' => $item->stall_id,
                    'booking_id' => $item->stall_booking_id,
                    'event_id' => $item->stall_event_id,

                    // Event data
                    'b2b_constrain' => $item->b2b_constrain,
                    'year' => $item->event_year,
                    'name' => $item->event_name,
                    'event_image' => $item->event_image,
                    'venue_details' => $item->venue_details,
                    'total_venue_area' => $item->total_venue_area,
                    'stall_price' => $item->stall_price,
                    'venue_booking_details' => $item->venue_booking_details,
                    'coordinator' => $item->coordinator,
                    'start_date' => $item->event_start_date,
                    'end_date' => $item->event_end_date,

                    // Stall details
                    'stall_size' => $item->stall_size,
                    'stall_location' => $item->stall_location,
                    'stall_type' => $item->stall_type,
                    'fascia' => $item->fascia,
                    'certificate' => $item->certificate,
                    'branding' => $item->branding,

                    // Pricing
                    'discount_code' => $item->discount_code,
                    'discount_amount' => $item->discount_amount,
                    'final_price' => $item->final_price,
                    'original_amount' => $item->original_amount,
                    'gst_amount' => $item->gst_amount,
                    'due_amount' => $item->due_amount,

                    // Stall timestamps
                    'created_at' => $item->stall_created_at,
                    'updated_at' => $item->stall_updated_at,
                ];
            })
            ->values()
            ->toArray();

        return (object) $booking;
    }

    public function bookingDatawithbookingideach($booking_id)
    {
        $bookingdata = DB::table('booking_record')
            ->where('booking_record.booking_id', $booking_id)

            ->leftJoin(
                'stall_booking_data',
                'booking_record.booking_id',
                '=',
                'stall_booking_data.booking_id'
            )

            ->leftJoin(
                'events',
                'stall_booking_data.event_id',
                '=',
                'events.event_id'
            )

            ->select(
                // =========================
                // Booking Record
                // =========================
                'booking_record.*',

                // =========================
                // Event
                // =========================
                'events.event_id as event_id',
                'events.b2b_constrain',
                'events.year as event_year',
                'events.name as event_name',
                'events.event_image',
                'events.venue_details',
                'events.total_venue_area',
                'events.stall_price',
                'events.venue_booking_details',
                'events.coordinator',
                'events.start_date as event_start_date',
                'events.end_date as event_end_date',
                'events.created_at as event_created_at',
                'events.updated_at as event_updated_at',

                // =========================
                // Stall Booking
                // =========================
                'stall_booking_data.id as stall_id',
                'stall_booking_data.booking_id as stall_booking_id',
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
                'stall_booking_data.due_amount',
                'stall_booking_data.created_at as stall_created_at',
                'stall_booking_data.updated_at as stall_updated_at'
            )
            ->get();

        if ($bookingdata->isEmpty()) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Booking Data
        |--------------------------------------------------------------------------
        */

        $first = $bookingdata->first();

        $booking = collect($first)->except([
            // Event fields
            'event_id',
            'b2b_constrain',
            'event_year',
            'event_name',
            'event_image',
            'venue_details',
            'total_venue_area',
            'stall_price',
            'venue_booking_details',
            'coordinator',
            'event_start_date',
            'event_end_date',
            'event_created_at',
            'event_updated_at',

            // Stall fields
            'stall_id',
            'stall_booking_id',
            'stall_event_id',
            'stall_size',
            'stall_location',
            'stall_type',
            'fascia',
            'certificate',
            'branding',
            'discount_code',
            'discount_amount',
            'final_price',
            'original_amount',
            'gst_amount',
            'due_amount',
            'stall_created_at',
            'stall_updated_at',
        ])->toArray();

        /*
        |--------------------------------------------------------------------------
        | Stalls + Event Data
        |--------------------------------------------------------------------------
        */

        $booking['stalls'] = $bookingdata
            ->filter(function ($item) {
                return !is_null($item->stall_id);
            })
            ->map(function ($item) {
                return [

                    // Stall Basic Data
                    'stall_id' => $item->stall_id,
                    'booking_id' => $item->stall_booking_id,
                    'event_id' => $item->stall_event_id,

                    // Event Data
                    'b2b_constrain' => $item->b2b_constrain,
                    'year' => $item->event_year,
                    'name' => $item->event_name,
                    'event_image' => $item->event_image,
                    'venue_details' => $item->venue_details,
                    'total_venue_area' => $item->total_venue_area,
                    'stall_price' => $item->stall_price,
                    'venue_booking_details' => $item->venue_booking_details,
                    'coordinator' => $item->coordinator,
                    'start_date' => $item->event_start_date,
                    'end_date' => $item->event_end_date,

                    // Stall Details
                    'stall_size' => $item->stall_size,
                    'stall_location' => $item->stall_location,
                    'stall_type' => $item->stall_type,
                    'fascia' => $item->fascia,
                    'certificate' => $item->certificate,
                    'branding' => $item->branding,

                    // Pricing
                    'discount_code' => $item->discount_code,
                    'discount_amount' => $item->discount_amount,
                    'final_price' => $item->final_price,
                    'original_amount' => $item->original_amount,
                    'gst_amount' => $item->gst_amount,
                    'due_amount' => $item->due_amount,

                    // Stall Timestamps
                    'created_at' => $item->stall_created_at,
                    'updated_at' => $item->stall_updated_at,
                ];
            })
            ->values()
            ->toArray();

        return $booking;
    }

    public function final_bookingdetails($bookingid)
    {
        /*
        |--------------------------------------------------------------------------
        | Booking
        |--------------------------------------------------------------------------
        */

        $booking = DB::table('booking_record')
            ->where('booking_id', $bookingid)
            ->first();

        if (!$booking) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        $company = DB::table('company_data')
            ->where('company_id', $booking->company_id)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Payment Records
        |--------------------------------------------------------------------------
        |
        | Get every payment record for this booking.
        |
        */

        $payments = DB::table('payment_records')
            ->where('booking_id', $bookingid)
            ->orderBy('id', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PAID AMOUNT
        |--------------------------------------------------------------------------
        |
        | One combined paid amount for the complete booking.
        |
        | Only approved payments are considered paid.
        |
        */

        $paidAmount = (float) DB::table('payment_records')
            ->where('booking_id', $bookingid)
            ->where('status', 'approved')
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Stall Details
        |--------------------------------------------------------------------------
        */

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

                'events.year as event_year',
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
        | TOTAL BOOKING AMOUNT
        |--------------------------------------------------------------------------
        */

        $totalAmount = (float) $stalls->sum(function ($stall) {
            return (float) ($stall->final_price ?? 0);
        });

        /*
        |--------------------------------------------------------------------------
        | TOTAL BOOKING DUE
        |--------------------------------------------------------------------------
        */

        $dueAmount = max(
            0,
            round($totalAmount - $paidAmount, 2)
        );

        /*
        |--------------------------------------------------------------------------
        | Stall Contacts
        |--------------------------------------------------------------------------
        */

        $stallIds = $stalls
            ->pluck('id')
            ->filter()
            ->values();

        $stallContacts = collect();

        if ($stallIds->isNotEmpty()) {
            $stallContacts = DB::table('stall_delegates as sd')
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
        }

        /*
        |--------------------------------------------------------------------------
        | Attach Contacts Array To Each Stall
        |--------------------------------------------------------------------------
        */

        $stalls->transform(function ($stall) use ($stallContacts) {

            $stall->contacts = $stallContacts
                ->get($stall->id, collect())
                ->values();

            return $stall;
        });

        /*
        |--------------------------------------------------------------------------
        | Billing Contact
        |--------------------------------------------------------------------------
        */


        $billingcontact = null;

        if (!empty($booking->billing_contact_id)) {

            $billingcontact = DB::table('contact')
                ->where('contact.contact_id', $booking->billing_contact_id)
                ->leftJoin(
                    'contact_email',
                    'contact.contact_id',
                    '=',
                    'contact_email.contact_id'
                )
                ->leftJoin(
                    'contact_mobile',
                    'contact.contact_id',
                    '=',
                    'contact_mobile.contact_id'
                )
                ->select(
                    'contact.contact_id',
                    'contact.company_id',
                    'contact.name',
                    'contact.designation',
                    'contact.billing_contact',
                    'contact_email.email',
                    'contact_mobile.mobile'
                )
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        |
        | Existing structure is preserved.
        |
        | Additional payment summary:
        |
        | $final_bookingdetails->total_amount
        | $final_bookingdetails->paid_amount
        | $final_bookingdetails->due_amount
        |
        */

        return (object) [
            'booking' => $booking,
            'company' => $company,
            'stalls' => $stalls,
            'billingcontact' => $billingcontact,
            'payments' => $payments,

            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
        ];
    }
}