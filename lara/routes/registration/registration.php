<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Registration\RegistrationController;

Route::get('/links', [RegistrationController::class, 'index'])->name('index');

Route::get('/', [RegistrationController::class, 'Form'])->name('formexhibitor');

Route::get('entries/{location}/{person}', [RegistrationController::class, 'formentries']);
Route::get('entries/', [RegistrationController::class, 'formentries']);
Route::get('entriesbyspecifics/{location}/{person}', [RegistrationController::class, 'formentriesbyspecifics']);
Route::get('store/{location}/{name}', [RegistrationController::class, 'store']);

Route::post('store/{location}/{name}', [RegistrationController::class, 'store']);

// ⚠️ KEEP THIS LAST
Route::get('/{location}/{person}', [RegistrationController::class, 'Form']);