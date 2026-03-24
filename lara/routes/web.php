<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'loginpage'])->name('login'); // show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // submit login
Route::get('/create', [AuthController::class, 'create'])->name('create'); // submit login
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/request-otp',[AuthController::class,'requestOtp'])->name('login.otp');

Route::post('/verify-otp',[AuthController::class,'verifyOtp'])->name('login.verify');

Route::get('/otp-list',[AuthController::class,'getOtp']);

use App\Http\Controllers\App;

Route::get('/home', [App::class, 'index'])->name('home'); // show login form
Route::get('/profile', [App::class, 'index'])->name('profile'); // submit login
Route::get('/layout', [App::class, 'index'])->name('layout'); // submit login
Route::get('/calendar', [App::class, 'index'])->name('calendar'); // submit login    

use App\Http\Controllers\RegisterController;
Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');

// Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');

// Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // submit login 

use App\Http\Controllers\UserController;

route::get('/userdata', [UserController::class, 'userdata']);

use App\Http\Controllers\EventController;

Route::get('/eventlist', [EventController::class, 'getUpcomingEvents']);
Route::get('/lasteventdetails/{id?}', [EventController::class, 'lastEventDetails']);
