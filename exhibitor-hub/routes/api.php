<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\EventsController;
use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\Api\AdminController;
// use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| Events APIs
|--------------------------------------------------------------------------
*/

// Route::get('/hello', function () {
//     return 'hello';
// });

Route::get('/event/list', [EventsController::class, 'eventlist']);
Route::get('bookingdata/{city}', [AdminController::class, 'listbycity']);



/*
|--------------------------------------------------------------------------
| Admin APIs
|--------------------------------------------------------------------------
*/

// Route::prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard']);
//     Route::get('/bookings', [AdminController::class, 'bookings']);
//     Route::get('/booking/{id}', [AdminController::class, 'booking']);
//     Route::post('/booking', [AdminController::class, 'storeBooking']);
// });


// /*
// |--------------------------------------------------------------------------
// | Customer APIs
// |--------------------------------------------------------------------------
// */

// Route::prefix('exhibitor')->group(function () {
//     Route::post('/login', [CustomerController::class, 'login']);
//     Route::post('/verify', [CustomerController::class, 'verify']);
//     Route::get('/dashboard', [CustomerController::class, 'dashboard']);
//     Route::get('/booking', [CustomerController::class, 'booking']);
//     Route::post('/branding', [CustomerController::class, 'branding']);
//     Route::post('/delegates', [CustomerController::class, 'delegates']);
// });