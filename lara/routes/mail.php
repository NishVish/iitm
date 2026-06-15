<?php

use Illuminate\Support\Facades\Route;









use App\Http\Controllers\Mail\MailController;

Route::get('/mail/test', [MailController::class, 'test']);
Route::get('/mail/massmail', [MailController::class, 'MassMailDashboard']);


