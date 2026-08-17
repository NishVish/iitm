<?php

use App\Http\Controllers\Dashboard\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('dashboard/', [Dashboard::class, 'index']);
