<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Tools\BadgeStation\BadgeStationController;


Route::get('/badgestation', [BadgeStationController::class, 'index'])->name('choose');

Route::get('/badgestation/scanner/{relay}', [BadgeStationController::class, 'scanner'])->name('scanner');
Route::post('/badgestation/scanner/{relay}', [BadgeStationController::class, 'scanner'])->name('scanner.store');
Route::get('/badgestation/interface/{relay}', [BadgeStationController::class, 'interface'])->name('choose');



Route::post('/update/relayid/{id}', [BadgeStationController::class, 'update'])->name('choose');
Route::post('/fetch/relayid/{id}', [BadgeStationController::class, 'fetch'])->name('choose');
