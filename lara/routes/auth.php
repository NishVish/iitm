<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\AuthController;
Route::get('temp', [AuthController::class, 'temp'])->name('temp'); // show login form
Route::get('/login', [AuthController::class, 'loginpage'])->name('login'); // show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // submit login
Route::get('/create', [AuthController::class, 'create'])->name('create'); // submit login
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/visitor-form', [AuthController::class, 'requestOtp'])->name('login.otp');
// Route::get('/visitor-form/{mobilenumber}/{eventid}', [AuthController::class, 'requestOtp'])->name('login.otp');
// Route::get('/request-otp/{mobilenumber}', [AuthController::class, 'requestOtp'])->name('login.otp');


Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('login.verify');
Route::get('/verify-otp', [AuthController::class, 'verifyOtp'])->name('login.verify');


Route::get('/otp-list', [AuthController::class, 'getOtp']);
