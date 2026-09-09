<?php

use App\Http\Controllers\Booking\BookingController;
use Illuminate\Support\Facades\Route;


// Add Booking routes here



Route::get('/create_booking/{companyid}', [BookingController::class, 'create_booking'])
    ->name('create_booking');

Route::get('space_booking', [BookingController::class, 'open_booking_page'])
    ->name('open_booking_page');
Route::get('space_booking/{id}', [BookingController::class, 'open_booking_page'])
    ->name('open_booking_page');

Route::post('/booking/create', [BookingController::class, 'createbooking_new'])
    ->name('createbooking');

Route::get('sales/booking/{companyid}', [BookingController::class, 'bookingdata'])
    ->name('bookingdata');

Route::get('{sales}/bookingsummary/{companyid}', [BookingController::class, 'bookingsummary'])
    ->name('bookingsummary');


Route::get('exhibitor/booking/{bookingid}', [BookingController::class, 'bookingprocess'])
    ->name('bookingprocess');


Route::get('exhibitor/booking/{bookingid}', [BookingController::class, 'bookingprocess'])
    ->name('bookingprocess');




// Route::get('exhibitor/booking/{step}/{bookingid}', [BookingController::class, 'bookingprocess'])
//     ->name('bookingprocess');



Route::post('/booking_store', [BookingController::class, 'booking_store'])
    ->name('booking_store');

Route::get('exhibitor/closebooking/{bookingid}', [BookingController::class, 'closebooking'])
    ->name('closebooking');
Route::get('exhibitor/openbooking/{bookingid}', [BookingController::class, 'openbooking'])
    ->name('openbooking');



// Route::get('exhibitor/booking/{bookingid}', [BookingController::class, 'step1_instruction'])
//     ->name('step1_instruction');




Route::get('/company_select/{companyid}', [BookingController::class, 'company_select'])
    ->name('company_select');

// improve it the amount should be active

// each row should aslo have gst that is 18% then the final price = origranl - discount + 18% of that


// total amount = all stall final price addition
// sgst = 9%
// cgst = 9%
// then add them total amount + sgst + cgst 

// total discount
// grand total