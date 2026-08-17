<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Backend\DatabaseController as BackendDatabaseController;

Route::get('/data', [BackendDatabaseController::class, 'databaseportal'])->name('databaseportal');

Route::get('/getcompanybyentrytype/{type}', [BackendDatabaseController::class, 'getcompanybyentrytype'])->name('getcompanybyentrytype');
Route::get('/otherregistration', [BackendDatabaseController::class, 'otherregistration'])->name('otherregistration');
// Route::get('/categorypass/{companyid}/{contactid}/{email}', [BackendDatabaseController::class, 'categorypass'])->name('categorypass');
// Route::get('/categoryfail/{companyid}/{contactid}/{email}', [BackendDatabaseController::class, 'categoryfail'])->name('categoryfail');


Route::get('/approved-category/{companyId}/{contactId}/{email}/{category}', [BackendDatabaseController::class, 'updateCategory']);
Route::get('/reject-company/{companyId}/{contactId}/{email}', [BackendDatabaseController::class, 'rejectCompany']);
