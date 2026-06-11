<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Assistant\AssistantController;


Route::get('/trainassistant/{type}', [AssistantController::class, 'trainAssistant']);
Route::get('/assistant/{type}', [AssistantController::class, 'assistant']);
Route::post('/assistant/{type}', [AssistantController::class, 'assistant']);
Route::post('/assistant/ask/{type}', [AssistantController::class, 'ask']);
