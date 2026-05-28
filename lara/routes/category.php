<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\IdentifycategoryController;


Route::get('api/identifycategory/{nameofthecompany}', [IdentifycategoryController::class, 'category']);


Route::post('/dictionary/update', [IdentifycategoryController::class, 'update'])->name('dictionary.update');
Route::get('/dictionary', [IdentifycategoryController::class, 'dictionaryEditor'])->name('dictionary.update');
Route::get('/dictionary/json', [IdentifycategoryController::class, 'getDictionaryJson']);
// Route::post('', [IdentifycategoryController::class,
