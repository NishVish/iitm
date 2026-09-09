<?php

// ============================================================
// app/Http/Controllers/CRUD/GetData/PaymentData.php
// ============================================================

namespace App\Http\Controllers\CRUD\GetData;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait PaymentData
{
    public function paymentData($companyid)
    {
        return DB::table('payment_records')
            ->where('company_id', $companyid)
            ->get();
    }

    public function paymentRequest()
    {
        $payments = DB::table('payment_records')
            ->where('status', 'pending')
            ->orderByDesc('id')
            ->get();

        foreach ($payments as $payment) {
            if ($payment->payment_date) {
                $payment->payment_date = Carbon::parse($payment->payment_date)
                    ->timezone(config('app.timezone'))
                    ->toDateTimeString();
            }

            if ($payment->approved_at) {
                $payment->approved_at = Carbon::parse($payment->approved_at)
                    ->timezone(config('app.timezone'))
                    ->toDateTimeString();
            }

            if ($payment->created_at) {
                $payment->created_at = Carbon::parse($payment->created_at)
                    ->timezone(config('app.timezone'))
                    ->toDateTimeString();
            }

            if ($payment->updated_at) {
                $payment->updated_at = Carbon::parse($payment->updated_at)
                    ->timezone(config('app.timezone'))
                    ->toDateTimeString();
            }
        }

        return $payments;
    }

    public function paymentinfobystallid($stallid)
    {


        $payment = DB::table('payment_records')
            ->where('stall_id', $stallid)
            ->get();

        return $payment;

    }
    public function approvePayment($paymentId, $approvedBy = null)
    {
        return DB::table('payment_records')
            ->where('id', $paymentId)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'approved_by' => $approvedBy,
                'approved_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function paymentinfo($bookingid)
    {



        try {

            /*
            |--------------------------------------------------------------------------
            | BOOKING
            |--------------------------------------------------------------------------
            */

            $bookingdata = DB::table('booking_record')
                ->where('booking_id', $bookingid)
                ->first();


            if (!$bookingdata) {

                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found.',
                    'data' => [],
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | STALLS
            |--------------------------------------------------------------------------
            |
            | stall_booking_data contains:
            |
            | final_price
            | original_amount
            | discount_amount
            | gst_amount
            | due_amount
            |
            |--------------------------------------------------------------------------
            */

            $stalls = DB::table('stall_booking_data')
                ->leftJoin(
                    'events',
                    'events.event_id',
                    '=',
                    'stall_booking_data.event_id'
                )
                ->where('stall_booking_data.booking_id', $bookingid)
                ->orderBy('stall_booking_data.id')
                ->select(
                    'stall_booking_data.*',
                    'events.name as event_name',
                    'events.year as event_year',
                    'events.venue_details as event_venue',
                    'events.start_date as event_start_date',
                    'events.end_date as event_end_date'
                )
                ->get();


            $result = [];


            foreach ($stalls as $stall) {

                /*
                |--------------------------------------------------------------------------
                | BASIC VALUES
                |--------------------------------------------------------------------------
                */

                $originalPrice = (float) ($stall->original_amount ?? 0);

                $discountAmount = (float) ($stall->discount_amount ?? 0);

                $finalPrice = (float) ($stall->final_price ?? 0);


                /*
                |--------------------------------------------------------------------------
                | FALLBACK CALCULATION
                |--------------------------------------------------------------------------
                |
                | If final_price is not stored correctly, calculate:
                |
                | Original Price - Discount
                |
                */

                if ($finalPrice <= 0 && $originalPrice > 0) {

                    $finalPrice = max(
                        0,
                        $originalPrice - $discountAmount
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | CONCLUSIVE PRICE
                |--------------------------------------------------------------------------
                |
                | Conclusive price =
                |
                | Final Price + 18% GST
                |
                */

                $gstAmount = round(
                    $finalPrice * 0.18,
                    2
                );


                $conclusivePrice = round(
                    $finalPrice + $gstAmount,
                    2
                );


                /*
                |--------------------------------------------------------------------------
                | PAYMENT RECORDS
                |--------------------------------------------------------------------------
                |
                | Get all payment entries for this booking + stall.
                |
                */

                $payments = DB::table('payment_records')
                    ->where('booking_id', $bookingid)
                    ->where('stall_id', $stall->id)
                    ->orderBy('payment_date')
                    ->orderBy('id')
                    ->get();


                /*
                |--------------------------------------------------------------------------
                | TOTAL PAID
                |--------------------------------------------------------------------------
                |
                | Only successful/approved payments are counted.
                |
                */

                $paidAmount = (float) $payments
                    ->filter(function ($payment) {

                        return in_array(
                            strtolower((string) $payment->status),
                            [
                                'paid',
                                'success',
                                'successful',
                                'approved',
                                'completed',
                            ],
                            true
                        );

                    })
                    ->sum('amount');


                /*
                |--------------------------------------------------------------------------
                | REMAINING AMOUNT
                |--------------------------------------------------------------------------
                */

                $remainingAmount = max(
                    0,
                    $conclusivePrice - $paidAmount
                );


                /*
                |--------------------------------------------------------------------------
                | PAYMENT STATUS
                |--------------------------------------------------------------------------
                */

                if ($conclusivePrice <= 0) {

                    $paymentStatus = 'not_required';

                } elseif ($paidAmount >= $conclusivePrice) {

                    $paymentStatus = 'paid';

                } elseif ($paidAmount > 0) {

                    $paymentStatus = 'partial';

                } else {

                    $paymentStatus = 'pending';

                }


                /*
                |--------------------------------------------------------------------------
                | RETURN STALL DATA
                |--------------------------------------------------------------------------
                */
                $result[] = [

                    'stall_id' => $stall->id,

                    'booking_id' => $stall->booking_id,

                    'event_id' => $stall->event_id,

                    'event_name' => $stall->event_name,

                    'event_year' => $stall->event_year,

                    'event_venue' => $stall->event_venue,

                    'event_start_date' => $stall->event_start_date,

                    'event_end_date' => $stall->event_end_date,

                    'stall_size' => $stall->stall_size,

                    'stall_location' => $stall->stall_location,

                    'stall_type' => $stall->stall_type,

                    'fascia' => $stall->fascia,

                    'certificate' => $stall->certificate,

                    'branding' => (int) $stall->branding,

                    // ...rest of your existing fields


                    /*
                    |--------------------------------------------------------------------------
                    | PRICE DETAILS
                    |--------------------------------------------------------------------------
                    */

                    'stall_price' => round(
                        $originalPrice,
                        2
                    ),

                    'area_required_original_price' => round(
                        $originalPrice,
                        2
                    ),

                    'discount_amount' => round(
                        $discountAmount,
                        2
                    ),

                    'final_price' => round(
                        $finalPrice,
                        2
                    ),

                    'gst_rate' => 18,

                    'gst_amount' => round(
                        $gstAmount,
                        2
                    ),

                    'conclusive_price' => round(
                        $conclusivePrice,
                        2
                    ),


                    /*
                    |--------------------------------------------------------------------------
                    | PAYMENT DETAILS
                    |--------------------------------------------------------------------------
                    */

                    'paid_amount' => round(
                        $paidAmount,
                        2
                    ),

                    'remaining_amount' => round(
                        $remainingAmount,
                        2
                    ),

                    'payment_status' => $paymentStatus,


                    /*
                    |--------------------------------------------------------------------------
                    | PAYMENT RECORDS
                    |--------------------------------------------------------------------------
                    */

                    'payments' => $payments->map(function ($payment) {

                        return [

                            'id' => $payment->id,

                            'booking_id' => $payment->booking_id,

                            'stall_id' => $payment->stall_id,

                            'payment_for' => $payment->payment_for,

                            'amount' => (float) $payment->amount,

                            'utr_id' => $payment->utr_id,

                            'status' => $payment->status,

                            'approved_by' => $payment->approved_by,

                            'payment_date' => $payment->payment_date,

                            'payment_method' => $payment->payment_method,

                            'transaction_id' => $payment->transaction_id,

                            'remarks' => $payment->remarks,

                            'rejection_reason' => $payment->rejection_reason,

                            'approved_at' => $payment->approved_at,

                            'created_at' => $payment->created_at,

                            'updated_at' => $payment->updated_at,

                        ];

                    })->values()->toArray(),

                ];

            }


            /*
            |--------------------------------------------------------------------------
            | BOOKING TOTALS
            |--------------------------------------------------------------------------
            */

            $totalOriginalPrice = collect($result)
                ->sum('area_required_original_price');


            $totalDiscount = collect($result)
                ->sum('discount_amount');


            $totalFinalPrice = collect($result)
                ->sum('final_price');


            $totalGst = collect($result)
                ->sum('gst_amount');


            $totalConclusivePrice = collect($result)
                ->sum('conclusive_price');


            $totalPaid = collect($result)
                ->sum('paid_amount');


            $totalRemaining = max(
                0,
                $totalConclusivePrice - $totalPaid
            );


            /*
            |--------------------------------------------------------------------------
            | FINAL RESPONSE
            |--------------------------------------------------------------------------
            */

            return [

                'success' => true,

                'message' => 'Payment data retrieved successfully.',

                'booking' => [

                    'booking_id' =>
                        $bookingdata->booking_id,

                    'company_id' =>
                        $bookingdata->company_id,

                    'billing_contact_id' =>
                        $bookingdata->billing_contact_id,

                    'sales_id' =>
                        $bookingdata->sales_id,

                    'discount_amount' =>
                        (float) $bookingdata->discount_amount,

                ],

                'summary' => [

                    'total_stalls' =>
                        count($result),

                    'total_original_price' =>
                        round($totalOriginalPrice, 2),

                    'total_discount_amount' =>
                        round($totalDiscount, 2),

                    'total_final_price' =>
                        round($totalFinalPrice, 2),

                    'gst_rate' =>
                        18,

                    'total_gst_amount' =>
                        round($totalGst, 2),

                    'total_conclusive_price' =>
                        round($totalConclusivePrice, 2),

                    'total_paid_amount' =>
                        round($totalPaid, 2),

                    'total_remaining_amount' =>
                        round($totalRemaining, 2),

                    'payment_status' =>
                        $totalConclusivePrice <= 0
                        ? 'not_required'
                        : (
                            $totalPaid >= $totalConclusivePrice
                            ? 'paid'
                            : (
                                $totalPaid > 0
                                ? 'partial'
                                : 'pending'
                            )
                        ),

                ],

                'stalls' => $result,

            ];

        } catch (\Throwable $e) {

            \Log::error(
                'Payment data error',
                [
                    'booking_id' => $bookingid,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );


            return response()->json([

                'success' => false,

                'message' =>
                    'Unable to retrieve payment data.',

                'error' =>
                    config('app.debug')
                    ? $e->getMessage()
                    : null,

                'data' => [],

            ], 500);
        }
    }
}

