<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebController;

// Route::get('/', [HomeController::class, 'index'])->name('home'); // show login form
Route::get('/', [WebController::class, 'index'])->name('web'); // show login form







use App\Http\Controllers\AuthController;
Route::get('temp', [AuthController::class, 'temp'])->name('temp'); // show login form
Route::get('/login', [AuthController::class, 'loginpage'])->name('login'); // show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // submit login
Route::get('/create', [AuthController::class, 'create'])->name('create'); // submit login
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/request-otp', [AuthController::class, 'requestOtp'])->name('login.otp');
Route::get('/request-otp/{mobilenumber}/{eventid}', [AuthController::class, 'requestOtp'])->name('login.otp');
// Route::get('/request-otp/{mobilenumber}', [AuthController::class, 'requestOtp'])->name('login.otp');

Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('login.verify');
Route::get('/verify-otp', [AuthController::class, 'verifyOtp'])->name('login.verify');

Route::get('/otp-list', [AuthController::class, 'getOtp']);





use App\Http\Controllers\App;
Route::get('/home', [App::class, 'index'])->name('home'); // show login form
Route::get('/profile', [App::class, 'index'])->name('profile'); // submit login
Route::get('/layout', [App::class, 'index'])->name('layout'); // submit login
Route::get('/calendar', [App::class, 'index'])->name('calendar'); // submit login    






use App\Http\Controllers\RegisterController;


Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // submit login 

Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');
// This is your current GET route that shows the form
Route::get('/registration/form', [RegisterController::class, 'registration_form'])->name('registration.form');
Route::post('/upload-logo', [RegisterController::class, 'uploadLogo']);
// ADD THIS ROUTE BELOW:
Route::post('/registration/submit', [RegisterController::class, 'registaritonsubmit'])->name('registration.submit');
Route::get('/category/{nameofthecompany}', [RegisterController::class, 'category'])->name('category');
Route::post('/enquiry', [RegisterController::class, 'register_enquiry'])->name('enquiry');
Route::get('/register_enquiry', [RegisterController::class, 'register_enquiry'])->name('register_enquiry');
Route::get('/emailtemplate', [RegisterController::class, 'emailtemplate'])->name('emailtemplate');
// Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');


use App\Http\Controllers\UserController;

route::get('/userdata', [UserController::class, 'userdata']);


use App\Http\Controllers\EventController;

Route::get('/api/events', [EventController::class, 'getUpcomingEvents']); // API-like route
Route::get('/events', [EventController::class, 'showevents']); // Blade page
Route::get('/lasteventdetails/{id?}', [EventController::class, 'lastEventDetails']);
Route::get('/register', [EventController::class, 'showevents'])->name('register');


use App\Http\Controllers\Tools;

// Tool Views
Route::match(['get', 'post'], '/lookuptest', [Tools::class, 'lookuptest']);
Route::get('/tools', [Tools::class, 'index'])->name('tools.index');
Route::get('/scanner/{operator}', [Tools::class, 'ocr'])->name('tools.ocr');

// API/AJAX Routes
Route::post('/ocr-lookup', [Tools::class, 'lookup'])->name('ocr.lookup');
Route::post('/ocr-save', [Tools::class, 'saveOcr'])->name('ocr.save');
Route::get('/temptable', [Tools::class, 'temptable'])->name('temptable');

// Data Management
Route::get('/ocrdata/{operator}', [Tools::class, 'list'])->name('documents.list');
Route::get('/edit/{id}', [Tools::class, 'edit'])->name('documents.edit');
Route::post('/update/{id}', [Tools::class, 'update'])->name('documents.update');
// Changed to DELETE to match the @method('DELETE') in your HTML form
Route::delete('/documents/delete/{id}', [Tools::class, 'destroy'])->name('documents.destroy');


use App\Http\Controllers\ExhibitorController;
Route::get('/visionstudio', [ExhibitorController::class, 'visionstudio'])->name('visionstudio');
Route::get('/exhibitor', [ExhibitorController::class, 'index'])->name('exhibitor');


use App\Http\Controllers\ParticipantController;

Route::get('/exhibiting', [ParticipantController::class, 'index'])->name('exhibiting');
Route::get('/attending', [ParticipantController::class, 'index'])->name('attending');
Route::get('/enquiry', [ParticipantController::class, 'enquriyform'])->name('enquiry');
Route::post('/visitor-form', [ParticipantController::class, 'fetchentity'])->name('visitor-form');

use App\Http\Controllers\InteracitveController;

Route::get('/interactive', [InteracitveController::class, 'index'])->name('interactive');
Route::get('/stalldemo', [InteracitveController::class, 'stalldemo'])->name('stalldemo');
Route::get('/reload', [InteracitveController::class, 'reload'])->name('reload');

Route::post('/upload-logo', [InteracitveController::class, 'uploadLogo'])->name('upload.logo');
Route::get('/clear-session', [InteracitveController::class, 'clearSession'])->name('session.clear');
Route::get('/blender-info', [InteracitveController::class, 'blender_info']);




use App\Http\Controllers\BookingController;

Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::get('/booking/step2', [BookingController::class, 'leadsearchpage'])->name('booking.step2');

Route::get('details/{mobile}', [BookingController::class, 'getDetails']);
Route::post('details/update', [BookingController::class, 'updatedetails']);
Route::post('lead/save', [BookingController::class, 'saveleaddetails']);
Route::get('searchlead/{mobile}', [BookingController::class, 'searchleadapi'])->name('searchlead');



use App\Http\Controllers\DatabaseController;


/* API Routes */
Route::get('/api/getAllCompanyData/{mobileNumber}', [DatabaseController::class, 'getAllCompanyData']);
Route::get('/api/getLatestCompanyData/{mobileNumber}/{querylength}/{city}/{response}', [DatabaseController::class, 'getLatestCompanyDatabymobile']);
Route::get('/api/getCompanyByMobileOrEmail/{mobileNumber}/{email}', [DatabaseController::class, 'getCompanyByMobileOrEmail']);
Route::get('/api/getDetails/{mobileNumber}', [DatabaseController::class, 'getDetails']);
Route::get('backend', [DatabaseController::class, 'index']);





use App\Http\Controllers\IdentifycategoryController;

Route::get('api/identifycategory/{nameofthecompany}', [IdentifycategoryController::class, 'category']);

Route::post('/dictionary/update', [IdentifycategoryController::class, 'update'])->name('dictionary.update');
Route::get('/dictionary', [IdentifycategoryController::class, 'dictionaryEditor'])->name('dictionary.update');
// Route::post('', [IdentifycategoryController::class,




use App\Http\Controllers\MailTestController;


Route::get('/Registrationcompletetemplate', [MailTestController::class, 'Registrationcomplete']);

Route::get('/mail-test', [MailTestController::class, 'index']);
Route::post('/mail-test/send', [MailTestController::class, 'send']);

use App\Mail\RegistrationSuccessMail;

Route::get('/Registrationcompletetemplate', [RegisterController::class, 'registrationsuccestemplate']);



use App\Http\Controllers\BadgeController;

Route::get('/badge-preview', [BadgeController::class, 'badgepreview']);

Route::get('/download-badge', [BadgeController::class, 'downloadBadge']);
route::get('generatebadge/{companyid}/{contactid}/{database}', [BadgeController::class, 'generatebadge']);


use App\Http\Controllers\AssetsController;

Route::get('/assets', [AssetsController::class, 'index']);



