<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\MailerController;


Route::get('/mailtest2', [MailerController::class, 'index']);
Route::get('/mail/send/{email}/{data}', [MailerController::class, 'sendRegistrationMail']);


Route::get('/mail/sendtest/{email}/{data}', [MailerController::class, 'sendRegistrationMaitest']);
Route::get('quickmailtest/{preview}', [MailerController::class, 'quickmailtest']);
Route::post('/sendmail', [MailerController::class, 'sendmail'])->name('sendmail');
Route::post('/sendmail/{eventid}/{companyid}/{contactid}/{email}', [MailerController::class, 'sendmailtothiscontact']);
