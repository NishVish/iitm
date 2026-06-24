<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



use App\Http\Controllers\Ai\AiController;
use App\Http\Controllers\Ai\RagController;


Route::get('/chat', [RagController::class, 'iitmchat']);
Route::get('/rawchat', [RagController::class, 'rawchat']);
