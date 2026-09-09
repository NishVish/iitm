<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Database\DatabaseController;

Route::get('/', [DatabaseController::class, 'index']);
