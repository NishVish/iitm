<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\AuthController as BackendAuthController;
use App\Http\Controllers\Backend\MasterBackendController;

Route::get('/backend', [BackendAuthController::class, 'login']);
Route::post('/backend/login', [BackendAuthController::class, 'verifyPin'])->name('backend.login');
Route::get('/backend/home', [BackendAuthController::class, 'home']);

use App\Http\Controllers\Backend\LeadsController;

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

Route::get('/backend/search', [DatabaseController::class, 'index']);





























































