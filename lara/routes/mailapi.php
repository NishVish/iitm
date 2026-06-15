<?php

use Illuminate\Support\Facades\Route;






use App\Http\Controllers\Mail\MailApi;

Route::get('/mail/api', [MailApi::class, 'list']);
Route::get('/mail/test', [MailApi::class, 'test']);
Route::get('/mail/sendRegistrationMail', [MailApi::class, 'sendRegistrationMail']);
Route::get('/mail/test/{type}', [MailApi::class, 'sendMail']);
Route::get('/massmail/test', [MailApi::class, 'massmailtest']);
Route::post('/massmail', [MailApi::class, 'massmail']);
