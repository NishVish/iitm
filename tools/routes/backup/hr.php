<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HR\HRController;

Route::get('/hr', [HRController::class, 'index']);