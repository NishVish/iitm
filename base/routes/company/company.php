<?php


use App\Http\Controllers\Company\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\CreateData\CreateDataController;

Route::get('company', [CompanyController::class, 'index']);
Route::post('sales/company_search', [CompanyController::class, 'search'])
    ->name('company.search');



Route::get('sales/add_company', [CompanyController::class, 'addCompany'])
    ->name('company.add');



Route::post('sales/create_company', [CreateDataController::class, 'createCompany'])
    ->name('company.create_company');



Route::get('sales/company_details/{companyid}', [CompanyController::class, 'companydetails'])
    ->name('companydetails');

Route::post('sales/search', [CompanyController::class, 'search'])
    ->name('search');




