<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registration\RegistrationApi;

Route::post('/registration/exhibitor', [RegistrationApi::class, 'store']);


Route::post('/registration', [RegistrationApi::class, 'store']);
Route::get('/registration/exhibitor/last', [RegistrationApi::class, 'last']);

// Route::get('/exhibitor/formentries', [RegistrationApi::class, 'formentries']);


