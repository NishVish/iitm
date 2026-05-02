<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



use App\Http\Controllers\Backend\AdminController;

Route::get('admin', [AdminController::class, 'index']);

Route::post('/assign-lead', [AdminController::class, 'assignlead'])->name('assign.lead');
