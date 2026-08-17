<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Registration\Spot\SpotController;
use App\Http\Controllers\Registration\RegistrationoldController;





Route::get('trade/{location}', [SpotController::class, 'index']);

Route::get('exhibitor/{location}/', [SpotController::class, 'index']);

Route::get('exhibitor/{location}/{clientof}/', [SpotController::class, 'index']);
//Route::get('save/{trade}/', [SpotController::class, 'store']);
Route::post('register/{spot_online}/{trade_exhibitor}', [SpotController::class, 'store'])->name('store_spot');



// Route::get('register/spot/{type}', [SpotController::class, 'index']);
// Route::post('register/{spot_online}/{trade_exhibitor}', [SpotController::class, 'store'])->name('store_spot');
