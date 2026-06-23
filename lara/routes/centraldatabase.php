<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\CentralDatabase\CentralDatabase;



Route::get('centraldatabase', [CentralDatabase::class, 'index']);
