<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayTestController extends Controller
{
    public function test()
    {
        try {
            $api = new Api(
                env('RAZORPAY_KEY'),
                env('RAZORPAY_SECRET')
            );

            $order = $api->order->create([
                'receipt' => 'rcptid_11',
                'amount' => 50000, // ₹500 = 50000 paise
                'currency' => 'INR'
            ]);

            return response()->json([
                'status' => 'success',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}