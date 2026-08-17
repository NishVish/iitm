<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\BookingController;


Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/step2', [BookingController::class, 'leadsearchpage'])->name('booking.step2');


Route::get('details/{mobile}', [BookingController::class, 'getDetails']);
Route::post('details/update', [BookingController::class, 'updatedetails']);
Route::post('lead/save', [BookingController::class, 'saveleaddetails']);
Route::get('searchlead/{mobile}', [BookingController::class, 'searchleadapi'])->name('searchlead');
