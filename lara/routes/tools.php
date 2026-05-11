<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Tools\BadgeController;


Route::get('badgesystem', [BadgeController::class, 'index']);
Route::get('getDataforbadge/{input?}', [BadgeController::class, 'getDataforbadge']);
Route::get('getDataforbadge', [BadgeController::class, 'getDataforbadge']);


// Route::post('/assign-lead', [AdminController::class, 'assignlead'])->name('assign.lead');
