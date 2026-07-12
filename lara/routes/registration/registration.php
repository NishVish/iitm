<?php

use Illuminate\Support\Facades\Route;


    require __DIR__ . '/spot/spot.php';

use App\Http\Controllers\Registration\RegistrationController;
use App\Http\Controllers\Registration\RegistrationoldController;


Route::get('/', [RegistrationoldController::class, 'choose'])->name('choose');

Route::get('/eventlist', [RegistrationoldController::class, 'eventlist'])->name('eventlist');
Route::get('/exhibitor', [RegistrationoldController::class, 'exhibitorform'])->name('exhibitorform');

Route::get('/trade/{location}', [RegistrationoldController::class, 'tradeform'])->name('tradeform');
Route::post('/store', [RegistrationoldController::class, 'store'])->name('store');
Route::get('badge/{id}', [RegistrationoldController::class, 'badge'])->name('store');
Route::get('retry/', [RegistrationoldController::class, 'eventlist'])->name('store');


// Route::get('/exhibitor/search/{keyword}', [RegistrationController::class, 'search']);
// Route::get('/links', [RegistrationController::class, 'index'])->name('index');
// Route::get('/search', [RegistrationController::class, 'enteryourmobile'])->name('enteryourmobile');
// Route::get('/', [RegistrationController::class, 'Form'])->name('formexhibitor');

// Route::get('/form', [RegistrationController::class, 'Form'])->name('formexhibitor');
// Route::get('delegates/{key}', [RegistrationController::class, 'delegatesInfo']);
// Route::get('delegatesInfobymobile/{key}', [RegistrationController::class, 'delegatesInfobymobile']);
// Route::post('delegatesupdate', [RegistrationController::class, 'editentry'])->name('exhibitors.update');
// Route::post('delegatesstore/{key}', [RegistrationController::class, 'delegatesstore']);

// Route::get('/{location}', [RegistrationController::class, 'Form'])->name('formexhibitor');

// Route::get('entries/{location}/{person}', [RegistrationController::class, 'formentries']);
// Route::get('entries/', [RegistrationController::class, 'formentries']);
// Route::get('entriesbyspecifics/{location}/{person}', [RegistrationController::class, 'formentriesbyspecifics']);
// Route::get('store/{location}/{name}', [RegistrationController::class, 'store']);



// Route::post('store/{location}/{name}', [RegistrationController::class, 'store']);

// // ⚠️ KEEP THIS LAST
// Route::get('/{location}/{person}', [RegistrationController::class, 'Form']);


