<?php

use App\Http\Controllers\Customer\ExhibitorController;
use Illuminate\Support\Facades\Route;

Route::get('exhibitor/dashboard/', [ExhibitorController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/exhibitor/{id}', [ExhibitorController::class, 'panel'])
    ->name('exhibitor.panel');

Route::get('/exhibitor/form', [ExhibitorController::class, 'form'])
    ->name('exhibitor.form');

Route::get('/exhibitor/welcome', [ExhibitorController::class, 'welcome'])
    ->name('exhibitor.welcome');

Route::get('/exhibitor/delegates', [ExhibitorController::class, 'delegates'])
    ->name('exhibitor.delegates');
Route::post('/exhibitor/store', [ExhibitorController::class, 'store'])
    ->name('exhibitor.store');

Route::post('/exhibitor/verify', [ExhibitorController::class, 'verify'])
    ->name('exhibitor.verify');