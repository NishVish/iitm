<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'loginpage'])->name('login'); // show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // submit login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


use App\Http\Controllers\MobileController;

Route::get('mobile/home', [MobileController::class, 'index'])->name('home'); // show login form
Route::get('mobile/profile', [MobileController::class, 'index'])->name('profile'); // submit login
Route::get('mobile/layout', [MobileController::class, 'index'])->name('layout'); // submit login
Route::get('mobile/calendar', [MobileController::class, 'index'])->name('calendar'); // submit login    