<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Web\Programs;


Route::get('/sponsorship', [Programs::class, 'sponsorship']);
Route::get('/sponsor-data', [Programs::class, 'data']);
Route::get('/hostedbuyer', [Programs::class, 'hostedbuyer']);
Route::get('/sponsor-data', [Programs::class, 'data']);
