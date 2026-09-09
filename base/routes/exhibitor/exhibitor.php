<?php

use App\Http\Controllers\Exhibitor\ExhibitorController;
use Illuminate\Support\Facades\Route;



Route::get('exhibitor/', [ExhibitorController::class, 'enteryoudetails'])
    ->name('enteryoudetails');




// Route::get('/exhibitor/booking/{id}', [ExhibitorController::class, 'exhibitorbooking'])
//     ->name('exhibitor.booking');







Route::get('exhibitor/{page}/{id}', [ExhibitorController::class, 'main'])
    ->name('exhibitor.main');



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

// payment record 
// logs
