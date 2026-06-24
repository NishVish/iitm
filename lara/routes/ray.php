<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\RayGptController;

// Route::get('/chat', [RayGptController::class, 'index']);
// Route::post('/chat', [RayGptController::class, 'chat']);
Route::post('/iitmbot', [RayGptController::class, 'iitmbot'])->name('iitmbot');
Route::get('/iitmbot', [RayGptController::class, 'chat'])->name('iitmbot');
Route::get('/bot/{text}', [RayGptController::class, 'bot']);
Route::get('/emotionofthis/{text}', [RayGptController::class, 'emotionofthis']);
Route::get('/colorofthisemotion/{text}', [RayGptController::class, 'colorofthisemotion']);

Route::get('/bot', [RayGptController::class, 'bot']);


Route::get('/debug/ollama', [RayGptController::class, 'ollamaDebug']);