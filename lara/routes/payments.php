<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\RazorpayTestController;
Route::get('/razorpay-test', [RazorpayTestController::class, 'test']);
