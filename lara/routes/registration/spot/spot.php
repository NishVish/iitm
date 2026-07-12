<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Registration\Spot\SpotController;
use App\Http\Controllers\Registration\RegistrationoldController;


Route::get('register/spot/{type}', [SpotController::class, 'index']);
Route::post('register/{spot_online}/{trade_exhibitor}', [SpotController::class, 'store'])->name('store_spot');
