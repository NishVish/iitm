<?php

use App\Http\Controllers\Authentication\Authentication;
use Illuminate\Support\Facades\Route;

Route::get('', [Authentication::class, 'login']);
Route::post('auth/verify', [Authentication::class, 'verifyUser']);
