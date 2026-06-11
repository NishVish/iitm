<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Utility\UtilityController;


Route::get('/pdftotext', [UtilityController::class, 'pdftotext']);


Route::post('/pdftotext', [UtilityController::class, 'convert'])->name('pdf.convert');

use App\Http\Controllers\Utility\MailingController as MailingControllerUtility;


Route::post('/mass-mail', [MailingControllerUtility::class, 'massmailing']);
Route::get('/mass-mail', [MailingControllerUtility::class, 'massmailing']);
use App\Http\Controllers\Mail\MailController as MailController_Utility;

Route::get('/template', [MailingControllerUtility::class, 'template']);
Route::get('/mailgateway', [MailingControllerUtility::class, 'mailgateway']);

Route::get('/mailgateway/{name}/{email}/{template}', [MailingControllerUtility::class, 'mailgateway'])
    ->name('mailgateway');
Route::get('/sender/{template}', [MailingControllerUtility::class, 'sender']);

use App\Http\Controllers\MailerController;


Route::get('/mailtest2', [MailerController::class, 'index']);
Route::get('/mail/send/{email}/{data}', [MailerController::class, 'sendRegistrationMail']);


Route::get('/mail/sendtest/{email}/{data}', [MailerController::class, 'sendRegistrationMaitest']);
Route::get('quickmailtest/{preview}', [MailerController::class, 'quickmailtest']);
Route::post('/sendmail', [MailerController::class, 'sendmail'])->name('sendmail');
Route::post('/sendmail/{eventid}/{companyid}/{contactid}/{email}', [MailerController::class, 'sendmailtothiscontact']);



use App\Http\Controllers\Utility\LayoutController;

Route::get('layout', [LayoutController::class, 'index']);
use App\Http\Controllers\Utility\DocumentationController;

Route::get('docs', [DocumentationController::class, 'index']);
Route::get('documentlist', [DocumentationController::class, 'documentlist']);


