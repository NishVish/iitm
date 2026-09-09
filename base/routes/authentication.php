<?php

use App\Http\Controllers\Authentication\Authentication;
use Illuminate\Support\Facades\Route;

Route::get('', [Authentication::class, 'exhibitorlogin']);
Route::post('auth/verify', [Authentication::class, 'verifyUser']);

Route::post('auth/exhibitor/verify', [Authentication::class, 'verifyExhibitor'])
    ->name('auth.exhibitor.verify');