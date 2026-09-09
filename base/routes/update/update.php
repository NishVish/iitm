<?php

use App\Http\Controllers\CRUD\UpdateData\UpdateDataController;
use Illuminate\Support\Facades\Route;


// Add Update routes here

Route::post('updatePayment', [UpdateDataController::class, 'updatePayment'])
    ->name('updatePayment');


Route::post('updateStallDetailsId', [UpdateDataController::class, 'stallDetailsIdUpdate'])
    ->name('updateStallDetailsId');

Route::post('updateStallDetails', [UpdateDataController::class, 'stallDetailsUpdate'])
    ->name('updateStallDetails');
Route::post('UpdateFaciaCertificate', [UpdateDataController::class, 'UpdateFaciaCertificate'])
    ->name('UpdateFaciaCertificate');

Route::post('updateStallBooking', [UpdateDataController::class, 'stallBookingUpdate'])
    ->name('updateStallBooking');


Route::post('updateBooking', [UpdateDataController::class, 'updateBooking'])
    ->name('updateBooking');


Route::post('updateAllContacts', [UpdateDataController::class, 'updateAllContacts'])
    ->name('updateAllContacts');


Route::post('updateContact', [UpdateDataController::class, 'updateContact'])
    ->name('updateContact');


Route::post('updateCompany', [UpdateDataController::class, 'updateCompany'])
    ->name('updateCompany');

