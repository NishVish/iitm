<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RazorPayController;


/*
|--------------------------------------------------------------------------
| Razorpay Payment Routes
|--------------------------------------------------------------------------
*/

Route::post(
    '/exhibitor/payment/razorpay/order',
    [RazorPayController::class, 'createOrder']
)->name('exhibitor.payment.razorpay.order');


Route::post(
    '/exhibitor/payment/razorpay/verify',
    [RazorPayController::class, 'verify']
)->name('exhibitor.payment.razorpay.verify');