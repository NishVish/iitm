<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\EventController;

// Route::get('/', [HomeController::class, 'index'])->name('home'); // show login form
Route::get('/', [WebController::class, 'index'])->name('web'); // show login form

Route::get('/login', [AuthController::class, 'loginpage'])->name('login'); // show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // submit login
Route::get('/create', [AuthController::class, 'create'])->name('create'); // submit login
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/request-otp', [AuthController::class, 'requestOtp'])->name('login.otp');

Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('login.verify');

Route::get('/otp-list', [AuthController::class, 'getOtp']);

use App\Http\Controllers\App;

Route::get('/home', [App::class, 'index'])->name('home'); // show login form
Route::get('/profile', [App::class, 'index'])->name('profile'); // submit login
Route::get('/layout', [App::class, 'index'])->name('layout'); // submit login
Route::get('/calendar', [App::class, 'index'])->name('calendar'); // submit login    

use App\Http\Controllers\RegisterController;
Route::get('/register', [EventController::class, 'showevents']); // Blade page

Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');
// This is your current GET route that shows the form
Route::get('/registration/form', [RegisterController::class, 'registration_form'])->name('registration.form');

// ADD THIS ROUTE BELOW:
Route::post('/registration/submit', [RegisterController::class, 'registaritonsubmit'])->name('registration.submit');
// Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');

// Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // submit login 

use App\Http\Controllers\UserController;

route::get('/userdata', [UserController::class, 'userdata']);



Route::get('/api/events', [EventController::class, 'getUpcomingEvents']); // API-like route
Route::get('/events', [EventController::class, 'showevents']); // Blade page
Route::get('/lasteventdetails/{id?}', [EventController::class, 'lastEventDetails']);


use App\Http\Controllers\Tools;

// Tool Views
Route::match(['get', 'post'], '/lookuptest', [Tools::class, 'lookuptest']);
Route::get('/tools', [Tools::class, 'index'])->name('tools.index');
Route::get('/scanner/{operator}', [Tools::class, 'ocr'])->name('tools.ocr');

// API/AJAX Routes
Route::post('/ocr-lookup', [Tools::class, 'lookup'])->name('ocr.lookup');
Route::post('/ocr-save', [Tools::class, 'saveOcr'])->name('ocr.save');

// Data Management
Route::get('/ocrdata/{operator}', [Tools::class, 'list'])->name('documents.list');
Route::get('/edit/{id}', [Tools::class, 'edit'])->name('documents.edit');
Route::post('/update/{id}', [Tools::class, 'update'])->name('documents.update');
// Changed to DELETE to match the @method('DELETE') in your HTML form
Route::delete('/documents/delete/{id}', [Tools::class, 'destroy'])->name('documents.destroy');