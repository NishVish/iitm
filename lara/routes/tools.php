<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Tools\BadgeController;
use App\Http\Controllers\Tools\Tools;

Route::get('tools', [Tools::class, 'index']);

Route::get('badgesystem', [BadgeController::class, 'index']);
Route::get('getDataforbadge/{input?}', [BadgeController::class, 'getDataforbadge']);
Route::get('getDataforbadge', [BadgeController::class, 'getDataforbadge']);
Route::get('badgescanner', [BadgeController::class, 'badgescanner']);
Route::post('decodeqr/{id}', [BadgeController::class, 'decodeqr']);
Route::get('decodeqr/{id}', [BadgeController::class, 'decodeqr']);

Route::get('badgescanner/{id}', [BadgeController::class, 'badgescanner']);
Route::get('printbadges/{id}', [BadgeController::class, 'badgeprinter']);
Route::get('gettheontect/{id}/{query}', [BadgeController::class, 'gettheontect']);// Route::post('/assign-lead', [AdminController::class, 'assignlead'])->name('assign.lead');


