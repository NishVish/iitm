<?php

use Illuminate\Support\Facades\Route;






use App\Http\Controllers\Mail\MailApi;

Route::get('/mail/test', [MailApi::class, 'test']);
