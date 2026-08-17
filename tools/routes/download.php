<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Web\DownloadController as WebDownloadController;

Route::get('/download/{filename}', [WebDownloadController::class, 'downloadfile'])->name('download');
// Route::get('/categorypass/{companyid}/{contactid}/{email}', [BackendDatabaseController::class, 'categorypass'])->name('categorypass');
// Route::get('/categoryfail/{companyid}/{contactid}/{email}', [BackendDatabaseController::class, 'categoryfail'])->name('categoryfail');


// Route::get('/approved-category/{companyId}/{contactId}/{email}/{category}', [BackendDatabaseController::class, 'updateCategory']);
// Route::get('/reject-company/{companyId}/{contactId}/{email}', [BackendDatabaseController::class, 'rejectCompany']);
