<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Registration\RegistrationController;

Route::get('/links', [RegistrationController::class, 'index'])->name('index');
Route::get('/', [RegistrationController::class, 'enteryourmobile'])->name('enteryourmobile');

Route::get('/form', [RegistrationController::class, 'Form'])->name('formexhibitor');
Route::get('delegates/{key}', [RegistrationController::class, 'delegatesInfo']);
Route::get('delegatesInfobymobile/{key}', [RegistrationController::class, 'delegatesInfobymobile']);
Route::post('delegatesupdate', [RegistrationController::class, 'editentry'])->name('exhibitors.update');
Route::post('delegatesstore/{key}', [RegistrationController::class, 'delegatesstore']);

Route::get('/{location}', [RegistrationController::class, 'Form'])->name('formexhibitor');

Route::get('entries/{location}/{person}', [RegistrationController::class, 'formentries']);
Route::get('entries/', [RegistrationController::class, 'formentries']);
Route::get('entriesbyspecifics/{location}/{person}', [RegistrationController::class, 'formentriesbyspecifics']);
Route::get('store/{location}/{name}', [RegistrationController::class, 'store']);


Route::post('store/{location}/{name}', [RegistrationController::class, 'store']);

// ⚠️ KEEP THIS LAST
Route::get('/{location}/{person}', [RegistrationController::class, 'Form']);


