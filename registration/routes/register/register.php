<?php

use App\Http\Controllers\Registration\RegistrationController;
use Illuminate\Support\Facades\Route;



Route::get('', [RegistrationController::class, 'index']);
Route::get('eventlist', [RegistrationController::class, 'eventlist']);
Route::get('review', [RegistrationController::class, 'review']);
Route::get('register/exhibitor', [RegistrationController::class, 'exhibitorregistration']);
Route::post('register/exhibitor', [RegistrationController::class, 'exhibitorstore']);
Route::get('register/{location}/{year}', [RegistrationController::class, 'registrationpage']);
Route::post('register/{location}/{year}', [RegistrationController::class, 'store']);