<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\BackendAuthController;
use App\Http\Controllers\Backend\MasterBackendController;
use App\Http\Controllers\Backend\FormController;
use App\Http\Controllers\Backend\Sales\LeadController;

Route::post('/testform', [FormController::class, 'index']);

Route::get('/backend', [BackendAuthController::class, 'login']);
Route::post('/backend/login', [BackendAuthController::class, 'verifyPin'])->name('backend.login');
Route::get('/backend/home', [BackendAuthController::class, 'home']);


Route::post('/logout', function () {
    session()->flush();
    return redirect('/backend')->with('success', 'Logged out');
});


Route::get('/backend/leads', [LeadsController::class, 'index']);
Route::post('/backend/mark-lead', [LeadsController::class, 'markaslead'])->name('backend.mark-lead');

Route::prefix('masterbackend')->group(function () {

    // 🔐 Main page (PIN + dashboard)
    Route::get('/', [MasterBackendController::class, 'index']);

    // 🔐 PIN check
    Route::post('/check-pin', [MasterBackendController::class, 'checkPin']);

    // 🔓 logout
    Route::get('/logout', [MasterBackendController::class, 'logout']);

    // 👥 users CRUD
    Route::post('/users/store', [MasterBackendController::class, 'store']);

    Route::post('/users/update/{id}', [MasterBackendController::class, 'update']);

    Route::get('/users/delete/{id}', [MasterBackendController::class, 'delete']);
});

use App\Http\Controllers\Backend\DatabaseController;
use App\Http\Controllers\Backend\SearchController;
use App\Http\Controllers\Backend\Sales\BookingController;

Route::get('/backend/search', [SearchController::class, 'index'])->name('backend.search');
Route::get('/backend/searchleads', [SearchController::class, 'searchleads']);
Route::get('/salesportal', [LeadController::class, 'index']);
Route::get('/allleads', [LeadController::class, 'allleads']);
Route::post('/backend/createlead', [LeadController::class, 'createlead']);
Route::post('/backend/booking/{lead_id}', [LeadController::class, 'booking']);
Route::get('/bookingportal', [BookingController::class, 'index'])->name('bookingportal');
Route::get('/leadsdetails/{id}', [LeadController::class, 'leadsdetails'])->name('searchlead');


route::post('proforma_invoice', [LeadController::class, 'proforma_invoice'])->name('proforma_invoice');
Route::get('/lead-search', [LeadController::class, 'index']);

// use App\Http\Controllers\Backend\BookingController;
Route::get('/backend/bookingportal', [BookingController::class, 'index']);
Route::get('/backend/bookingportal/instruction', [BookingController::class, 'instruction']);
Route::get('/backend/bookingportal/payment', [BookingController::class, 'payment']);
Route::post('/backend/bookingportal/processbooking', [BookingController::class, 'processbooking']);

use App\Http\Controllers\Backend\PaymentController;

Route::get('/payment-success', [PaymentController::class, 'handleSuccess'])
    ->name('payment.success');



use App\Http\Controllers\Backend\ExampleController;

Route::get('/example/bookingprocess', [ExampleController::class, 'bookingprocess']);




use App\Http\Controllers\Backend\BillingController;

Route::get('/invoice/{id}', [BillingController::class, 'invoice']);
Route::get('/perfoma/{id}', [BillingController::class, 'performa']);















































