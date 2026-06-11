<?php

use Illuminate\Support\Facades\Route;









use App\Http\Controllers\Mail\MailController;

Route::get('/mail/test', [MailController::class, 'test']);


