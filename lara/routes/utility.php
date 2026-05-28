<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Utility\UtilityController;


Route::get('/pdftotext', [UtilityController::class, 'pdftotext']);


Route::post('/pdftotext', [UtilityController::class, 'convert'])->name('pdf.convert');

use App\Http\Controllers\Utility\MailingController;


Route::post('/mass-mail', [MailingController::class, 'massmailing']);
Route::get('/mass-mail', [MailingController::class, 'massmailing']);