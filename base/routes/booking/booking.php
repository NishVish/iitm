<?php

use App\Http\Controllers\Booking\BookingController;
use Illuminate\Support\Facades\Route;


// Add Booking routes here



Route::get('/add_booking', [BookingController::class, 'add_booking'])
    ->name('add_booking');



Route::get('/add_booking_for/{companyid}', [BookingController::class, 'add_booking_for'])
    ->name('add_booking_for');