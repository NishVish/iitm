<?php

namespace App\Http\Controllers\CRUD\UpdateData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RazorPayController;

trait PaymentUpdate
{
    public function updatePayment(Request $request)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | VALIDATION
            |--------------------------------------------------------------------------
            */

            $request->validate([
                'booking_id' => 'required|string',

                'payment_type' => 'required|in:full,partial,stall',

                'amount' => 'required|numeric|min:0.01',

                'payment_method' => 'required|string|max:50',

                'payment_date' => 'required|date',

                'stall_id' => 'nullable|string|max:50',

                'utr_id' => 'nullable|string|max:100',

                'transaction_id' => 'nullable|string|max:100',

                'remarks' => 'nullable|string',

                'stalls' => 'nullable|array',

                'stalls.*.stall_id' => 'required_with:stalls|string|max:50',

                'stalls.*.price' => 'nullable|numeric|min:0',
            ]);


            /*
            |--------------------------------------------------------------------------
            | BASIC VALUES
            |--------------------------------------------------------------------------
            */

            $bookingId = $request->booking_id;

            $paymentType = $request->payment_type;

            $requestedAmount = (float) $request->amount;


            /*
            |--------------------------------------------------------------------------
            | CHECK BOOKING
            |--------------------------------------------------------------------------
            */

            $booking = DB::table('booking_record')
                ->where('booking_id', $bookingId)
                ->first();

            if (!$booking) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Booking not found.');
            }


            /*
            |--------------------------------------------------------------------------
            | GET ALL STALLS BELONGING TO BOOKING
            |--------------------------------------------------------------------------
            */

            $bookingStalls = DB::table('stall_booking_data')
                ->where('booking_id', $bookingId)
                ->get();


            if ($bookingStalls->isEmpty()) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'No stalls found for this booking.');
            }


            /*
            |--------------------------------------------------------------------------
            | BUILD STALL PAYMENT DETAILS
            |--------------------------------------------------------------------------
            |
            | Every stall has:
            |
            | final_price
            | approved paid amount
            | remaining due amount
            |
            |--------------------------------------------------------------------------
            */

            $stallDetails = [];

            foreach ($bookingStalls as $stall) {

                /*
                 * Your stall table appears to use stall_id.
                 *
                 * Fallback to id in case the table uses id instead.
                 */
                $stallId = $stall->stall_id ?? $stall->id;

                if (!$stallId) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | FINAL PRICE OF STALL
                |--------------------------------------------------------------------------
                */

                $finalPrice = (float) ($stall->final_price ?? 0);


                /*
                |--------------------------------------------------------------------------
                | ALREADY APPROVED PAYMENT FOR THIS STALL
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | Payments are now stored separately by stall_id.
                |
                |--------------------------------------------------------------------------
                */

                $paidAmount = (float) DB::table('payment_records')
                    ->where('booking_id', $bookingId)
                    ->where('stall_id', $stallId)
                    ->where('status', 'approved')
                    ->sum('amount');


                /*
                |--------------------------------------------------------------------------
                | REMAINING AMOUNT
                |--------------------------------------------------------------------------
                */

                $dueAmount = max(
                    0,
                    $finalPrice - $paidAmount
                );


                $stallDetails[$stallId] = [
                    'stall_id' => $stallId,
                    'final_price' => $finalPrice,
                    'paid_amount' => $paidAmount,
                    'due_amount' => $dueAmount,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | TOTAL BOOKING DUE
            |--------------------------------------------------------------------------
            */

            $totalDue = round(
                collect($stallDetails)->sum('due_amount'),
                2
            );


            /*
            |--------------------------------------------------------------------------
            | FULL PAYMENT
            |--------------------------------------------------------------------------
            |
            | FULL PAYMENT = PAY ALL STALLS.
            |
            | Example:
            |
            | Stall A = 64,000
            | Stall B = 92,000
            | Stall C = 305,000
            |
            | Total = 461,000
            |
            | We DO NOT create:
            |
            | booking_id = BK...
            | stall_id = NULL
            | amount = 461000
            |
            | Instead we create:
            |
            | booking_id = BK...
            | stall_id = A
            | amount = 64000
            |
            | booking_id = BK...
            | stall_id = B
            | amount = 92000
            |
            | booking_id = BK...
            | stall_id = C
            | amount = 305000
            |
            |--------------------------------------------------------------------------
            */

            if ($paymentType === 'full') {

                if ($totalDue <= 0) {

                    return redirect()
                        ->back()
                        ->with('error', 'There is no remaining amount to pay.');
                }


                /*
                |--------------------------------------------------------------------------
                | GET STALLS FROM POST
                |--------------------------------------------------------------------------
                |
                | Your form is already sending:
                |
                | stalls[stall_id][stall_id]
                | stalls[stall_id][price]
                |
                |--------------------------------------------------------------------------
                */

                $postedStalls = $request->input('stalls', []);


                if (empty($postedStalls)) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'No stalls were submitted for full payment.'
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | PREPARE PAYMENT RECORDS
                |--------------------------------------------------------------------------
                */

                $paymentRecords = [];

                $calculatedFullAmount = 0;


                foreach ($postedStalls as $postedStall) {

                    $stallId = $postedStall['stall_id'] ?? null;

                    if (!$stallId) {

                        return redirect()
                            ->back()
                            ->withInput()
                            ->with('error', 'Invalid stall selected.');
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SECURITY:
                    | CHECK THAT POSTED STALL BELONGS TO THIS BOOKING
                    |--------------------------------------------------------------------------
                    */

                    if (!isset($stallDetails[$stallId])) {

                        return redirect()
                            ->back()
                            ->withInput()
                            ->with(
                                'error',
                                'Invalid stall selected for this booking.'
                            );
                    }


                    $stall = $stallDetails[$stallId];


                    /*
                    |--------------------------------------------------------------------------
                    | USE SERVER-SIDE DUE AMOUNT
                    |--------------------------------------------------------------------------
                    |
                    | DO NOT trust:
                    |
                    | stalls[x][price]
                    |
                    | from browser.
                    |
                    | We use the database-calculated due amount.
                    |--------------------------------------------------------------------------
                    */

                    $stallDue = round(
                        (float) $stall['due_amount'],
                        2
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SKIP ALREADY PAID STALLS
                    |--------------------------------------------------------------------------
                    */

                    if ($stallDue <= 0) {
                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ONE PAYMENT RECORD FOR THIS STALL
                    |--------------------------------------------------------------------------
                    */

                    $paymentRecords[] = [
                        'booking_id' => $bookingId,

                        'stall_id' => $stallId,

                        'payment_for' => 'full_stall_payment',

                        'amount' => $stallDue,

                        'utr_id' => $request->utr_id,

                        'status' => 'pending',

                        'approved_by' => null,

                        'payment_date' => $request->payment_date,

                        'payment_method' => $request->payment_method,

                        'transaction_id' => $request->transaction_id,

                        'remarks' => $request->remarks,

                        'rejection_reason' => null,

                        'approved_at' => null,

                        'created_at' => now(),

                        'updated_at' => now(),
                    ];


                    $calculatedFullAmount += $stallDue;
                }


                /*
                |--------------------------------------------------------------------------
                | CHECK CALCULATED FULL AMOUNT
                |--------------------------------------------------------------------------
                */

                $calculatedFullAmount = round(
                    $calculatedFullAmount,
                    2
                );


                if ($calculatedFullAmount <= 0) {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'All stalls are already fully paid.'
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT:
                |
                | The amount sent by browser is NOT trusted.
                |
                | The server-calculated amount must match the actual
                | booking remaining amount.
                |--------------------------------------------------------------------------
                */

                if (abs($calculatedFullAmount - $totalDue) > 0.01) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Payment amount does not match the current stall balance. Please refresh and try again.'
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | INSERT ALL STALL PAYMENTS IN ONE TRANSACTION
                |--------------------------------------------------------------------------
                */

                DB::transaction(function () use ($paymentRecords) {

                    foreach ($paymentRecords as $paymentRecord) {

                        DB::table('payment_records')
                            ->insert($paymentRecord);
                    }
                });


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                return redirect()
                    ->back()
                    ->with(
                        'success',
                        'Full payment of ₹' .
                        number_format($calculatedFullAmount, 2) .
                        ' submitted successfully. Separate payment records were created for each stall and are pending approval.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | PARTIAL PAYMENT
            |--------------------------------------------------------------------------
            |
            | Partial payment remains booking-level because the user is
            | paying an arbitrary amount rather than clearing a particular
            | stall.
            |
            | stall_id = NULL
            |
            |--------------------------------------------------------------------------
            */

            if ($paymentType === 'partial') {

                if ($totalDue <= 0) {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'There is no remaining amount to pay.'
                        );
                }


                if ($requestedAmount > $totalDue) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Payment amount cannot be greater than the total remaining amount of ₹' .
                            number_format($totalDue, 2)
                        );
                }


                $paymentData = [
                    'booking_id' => $bookingId,

                    'stall_id' => null,

                    'payment_for' => 'partial_booking_payment',

                    'amount' => round($requestedAmount, 2),

                    'utr_id' => $request->utr_id,

                    'status' => 'pending',

                    'approved_by' => null,

                    'payment_date' => $request->payment_date,

                    'payment_method' => $request->payment_method,

                    'transaction_id' => $request->transaction_id,

                    'remarks' => $request->remarks,

                    'rejection_reason' => null,

                    'approved_at' => null,

                    'created_at' => now(),

                    'updated_at' => now(),
                ];


                DB::table('payment_records')
                    ->insert($paymentData);


                return redirect()
                    ->back()
                    ->with(
                        'success',
                        'Partial payment of ₹' .
                        number_format($requestedAmount, 2) .
                        ' submitted successfully and is pending approval.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | SPECIFIC STALL PAYMENT
            |--------------------------------------------------------------------------
            |
            | This payment is linked directly to ONE stall.
            |
            | stall_id = selected stall ID
            |--------------------------------------------------------------------------
            */

            if ($paymentType === 'stall') {

                $stallId = $request->stall_id;


                if (!$stallId) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Please select a stall.'
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | VERIFY STALL BELONGS TO BOOKING
                |--------------------------------------------------------------------------
                */

                if (!isset($stallDetails[$stallId])) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Selected stall does not belong to this booking.'
                        );
                }


                $selectedStall = $stallDetails[$stallId];

                $stallDue = round(
                    (float) $selectedStall['due_amount'],
                    2
                );


                if ($stallDue <= 0) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'The selected stall has no remaining amount.'
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | SERVER CALCULATES AMOUNT
                |--------------------------------------------------------------------------
                |
                | The browser amount is ignored.
                |
                | Selecting "Pay Specific Stall" means clear that stall.
                |--------------------------------------------------------------------------
                */

                $paymentAmount = $stallDue;


                $paymentData = [
                    'booking_id' => $bookingId,

                    'stall_id' => $stallId,

                    'payment_for' => 'stall_payment',

                    'amount' => $paymentAmount,

                    'utr_id' => $request->utr_id,

                    'status' => 'pending',

                    'approved_by' => null,

                    'payment_date' => $request->payment_date,

                    'payment_method' => $request->payment_method,

                    'transaction_id' => $request->transaction_id,

                    'remarks' => $request->remarks,

                    'rejection_reason' => null,

                    'approved_at' => null,

                    'created_at' => now(),

                    'updated_at' => now(),
                ];


                DB::table('payment_records')
                    ->insert($paymentData);


                return redirect()
                    ->back()
                    ->with(
                        'success',
                        'Payment of ₹' .
                        number_format($paymentAmount, 2) .
                        ' submitted for stall ' .
                        $stallId .
                        ' and is pending approval.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | FALLBACK
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Invalid payment type.'
                );


        } catch (\Illuminate\Validation\ValidationException $e) {

            throw $e;

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Payment could not be submitted: ' .
                    $e->getMessage()
                );
        }
    }


    public function paymentStatusUpdate(Request $request)
    {
        $payment_id = $request->payment_id;

        $payment_record = DB::table('payment_records')
            ->where('id', $payment_id)
            ->first();

        if (!$payment_record) {
            return redirect()
                ->back()
                ->with('error', 'Payment record not found.');
        }

        DB::table('payment_records')
            ->where('id', $payment_id)
            ->update([
                'status' => $request->action,
                'approved_at' => now(),
            ]);

        return redirect()
            ->route('admin.paymentRequest')
            ->with('success', 'Payment approved successfully.');
    }


}