<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\DatabaseController;


/* API Routes */
Route::get('/api/getAllCompanyData/{mobileNumber}', [DatabaseController::class, 'getAllCompanyData']);
Route::get('/api/getLatestCompanyData/{mobileNumber}/{querylength}/{city}/{response}', [DatabaseController::class, 'getLatestCompanyDatabymobile']);
Route::get('/api/getCompanyByMobileOrEmail/{mobileNumber}/{email}', [DatabaseController::class, 'getCompanyByMobileOrEmail']);
Route::get('/api/getLatestContactId/{mobileNumber}', [DatabaseController::class, 'getLatestContactId']);
Route::get('/api/getDetails/{mobileNumber}', [DatabaseController::class, 'getDetails']);
// Route::get('backend', [DatabaseController::class, 'index']);
