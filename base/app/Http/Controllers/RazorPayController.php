<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Throwable;

class RazorPayController extends Controller
{
    /**
     * Create Razorpay Order
     *
     * POST:
     * /exhibitor/payment/razorpay/order
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|string|max:50',
            'stall_id' => 'required|string|max:50',
            'payment_type' => 'required|in:full,partial',
            'amount' => 'required|numeric|min:1',
        ]);

        try {

            $keyId = config('services.razorpay.key_id');
            $keySecret = config('services.razorpay.key_secret');

            if (empty($keyId) || empty($keySecret)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay credentials are not configured.'
                ], 500);
            }

            /*
             * ---------------------------------------------------------
             * Get the selected stall
             * ---------------------------------------------------------
             */
            $stall = DB::table('stall_booking_data')
                ->where('id', $request->stall_id)
                ->where('booking_id', $request->booking_id)
                ->first();

            if (!$stall) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected stall was not found.'
                ], 404);
            }

            /*
             * ---------------------------------------------------------
             * Calculate actual remaining amount SERVER-SIDE.
             *
             * Never trust the amount coming from JavaScript.
             * ---------------------------------------------------------
             */
            $finalPrice = (float) ($stall->final_price ?? 0);

            $gstAmount = (float) ($stall->gst_amount ?? 0);

            /*
             * If conclusive price is final_price + GST,
             * use that as the amount payable.
             */
            $conclusivePrice = $finalPrice + $gstAmount;

            /*
             * Get already successful/approved payments for this stall.
             */
            $paidAmount = (float) DB::table('payment_records')
                ->where('booking_id', $request->booking_id)
                ->where('stall_id', $request->stall_id)
                ->whereIn('status', ['success', 'approved', 'paid'])
                ->sum('amount');

            $remainingAmount = max(
                0,
                $conclusivePrice - $paidAmount
            );

            if ($remainingAmount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'This stall has already been fully paid.'
                ], 422);
            }

            $requestedAmount = round(
                (float) $request->amount,
                2
            );

            if ($requestedAmount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount must be greater than zero.'
                ], 422);
            }

            if ($requestedAmount > $remainingAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount cannot exceed the remaining stall balance.'
                ], 422);
            }

            /*
             * Razorpay uses the smallest currency unit.
             *
             * ₹1,000 = 100000 paise
             */
            $amountInPaise = (int) round(
                $requestedAmount * 100
            );

            /*
             * Razorpay minimum order amount is ₹1.
             */
            if ($amountInPaise < 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimum Razorpay payment amount is ₹1.'
                ], 422);
            }

            /*
             * ---------------------------------------------------------
             * Create Razorpay client using ENV configuration.
             *
             * Nothing is passed from Blade.
             * ---------------------------------------------------------
             */
            $api = new Api(
                $keyId,
                $keySecret
            );

            /*
             * Receipt must be <= 40 characters.
             */
            $receipt = 'PAY-' .
                substr($request->booking_id, 0, 15) .
                '-' .
                substr($request->stall_id, 0, 15) .
                '-' .
                time();

            $order = $api->order->create([
                'receipt' => $receipt,
                'amount' => $amountInPaise,
                'currency' => 'INR',

                /*
                 * We are controlling the partial payment ourselves.
                 * Therefore one Razorpay order represents one payment.
                 */
                'partial_payment' => false,

                'notes' => [
                    'booking_id' => $request->booking_id,
                    'stall_id' => $request->stall_id,
                    'payment_type' => $request->payment_type,
                ],
            ]);

            return response()->json([
                'success' => true,

                'order_id' => $order['id'],

                'amount' => $order['amount'],

                'currency' => $order['currency'],

                'booking_id' => $request->booking_id,

                'stall_id' => $request->stall_id,

                'payment_type' => $request->payment_type,
            ]);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create Razorpay order.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }


    /**
     * Verify Razorpay Payment
     *
     * POST:
     * /exhibitor/payment/razorpay/verify
     */
    public function verify(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|string|max:50',
            'stall_id' => 'required|string|max:50',
            'payment_type' => 'required|in:full,partial',
            'amount' => 'required|numeric|min:1',

            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        try {

            $keyId = config('services.razorpay.key_id');
            $keySecret = config('services.razorpay.key_secret');

            if (empty($keyId) || empty($keySecret)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay credentials are not configured.'
                ], 500);
            }

            /*
             * ---------------------------------------------------------
             * Verify that the order exists and belongs to this
             * booking/stall before accepting the payment.
             * ---------------------------------------------------------
             */
            $api = new Api(
                $keyId,
                $keySecret
            );

            $order = $api->order->fetch(
                $request->razorpay_order_id
            );

            $orderNotes = $order['notes'] ?? [];

            if (
                ($orderNotes['booking_id'] ?? null)
                !== $request->booking_id
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking does not match Razorpay order.'
                ], 422);
            }

            if (
                ($orderNotes['stall_id'] ?? null)
                !== $request->stall_id
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stall does not match Razorpay order.'
                ], 422);
            }

            /*
             * ---------------------------------------------------------
             * Verify Razorpay signature.
             *
             * Razorpay requires:
             *
             * order_id + "|" + payment_id
             *
             * signed using the Key Secret.
             * ---------------------------------------------------------
             */
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' =>
                    $request->razorpay_order_id,

                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,

                'razorpay_signature' =>
                    $request->razorpay_signature,
            ]);

            /*
             * ---------------------------------------------------------
             * Fetch actual Razorpay payment.
             * ---------------------------------------------------------
             */
            $payment = $api->payment->fetch(
                $request->razorpay_payment_id
            );

            if (($payment['status'] ?? '') !== 'captured') {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay payment was not captured.'
                ], 422);
            }

            /*
             * Razorpay amount is in paise.
             */
            $razorpayAmount = (int) (
                $payment['amount'] ?? 0
            );

            $requestedAmountPaise = (int) round(
                ((float) $request->amount) * 100
            );

            /*
             * Make sure the amount returned by Razorpay is exactly
             * the amount we created the order for.
             */
            if ($razorpayAmount !== $requestedAmountPaise) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount does not match the Razorpay order.'
                ], 422);
            }

            /*
             * ---------------------------------------------------------
             * Prevent duplicate payment records.
             * ---------------------------------------------------------
             */
            $existingPayment = DB::table('payment_records')
                ->where('transaction_id', $request->razorpay_payment_id)
                ->first();

            if ($existingPayment) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment has already been recorded.',
                    'payment_id' => $existingPayment->id,
                ]);
            }

            /*
             * ---------------------------------------------------------
             * Save payment.
             *
             * Razorpay payment is already verified, so mark it
             * successful/approved.
             * ---------------------------------------------------------
             */
            $paymentRecordId = DB::table('payment_records')->insertGetId([
                'booking_id' => $request->booking_id,

                'stall_id' => $request->stall_id,

                'payment_for' => 'stall',

                'amount' => round(
                    (float) $request->amount,
                    2
                ),

                'utr_id' => $request->razorpay_payment_id,

                'status' => 'success',

                'approved_by' => null,

                'payment_date' => now(),

                'payment_method' => 'razorpay',

                'transaction_id' =>
                    $request->razorpay_payment_id,

                'remarks' =>
                    'Razorpay payment. Order ID: ' .
                    $request->razorpay_order_id,

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,

                'message' =>
                    'Payment completed successfully.',

                'payment_id' =>
                    $paymentRecordId,

                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,

                'razorpay_order_id' =>
                    $request->razorpay_order_id,
            ]);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Payment verification failed.',

                'error' => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 422);
        }
    }
}