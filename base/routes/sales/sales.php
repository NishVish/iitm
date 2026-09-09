<?php

use App\Http\Controllers\Sales\SalesController;
use Illuminate\Support\Facades\Route;


// Add Sales routes here


Route::get('sales/', [SalesController::class, 'index']);

Route::get('login_sales/', [SalesController::class, 'login_sales']);
Route::post('login_sales/', [SalesController::class, 'login_sales']);


Route::get('sales/stallsbyevent/{id}', [SalesController::class, 'stallsbyevent'])
    ->name('stallsbyevent');