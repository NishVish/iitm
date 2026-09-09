<?php

use App\Http\Controllers\Backend\BackendController;
use Illuminate\Support\Facades\Route;


// Add Backend routes here

Route::get('/backend', [BackendController::class, 'backend'])
    ->name('backend');

Route::get('/backendbackendcreate', [BackendController::class, 'backendcreate'])
    ->name('backendcreate');

Route::get('/runquery', [BackendController::class, 'runquery'])
    ->name('runquery');




