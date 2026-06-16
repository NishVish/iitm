<?php

use Illuminate\Support\Facades\Route;









use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Mail\MailServices;

Route::get('/mail/test', [MailController::class, 'test']);
Route::get('/mail/massmail', [MailController::class, 'MassMailDashboard']);


Route::get('/mail/registration', [MailServices::class, 'sendRegistrationMail']);	
Route::post('/mail/registration', [MailServices::class, 'sendRegistrationMail']);	
