<?php


use App\Http\Controllers\Company\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('company', [CompanyController::class, 'index']);
Route::post('/company_search', [CompanyController::class, 'search'])
    ->name('company.search');


Route::post('search', [CompanyController::class, 'search'])
    ->name('search');