<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ExhibitorController;
Route::get('/visionstudio', [ExhibitorController::class, 'visionstudio'])->name('visionstudio');
Route::get('/exhibitor', [ExhibitorController::class, 'index'])->name('exhibitor');
