<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



use App\Http\Controllers\Ai\AiController;
use App\Http\Controllers\Ai\RagController;

// Route::get('/updateData', [RagController::class, 'updateData']);
Route::get('/ai/rag/updatedata', [RagController::class, 'updatedata']);
Route::get('/ai/rag/ask', [RagController::class, 'ask']);

Route::post('/ai/rag/ask', [RagController::class, 'ask']);
Route::get('/ai/rag/test', [RagController::class, 'RagTest']);
Route::get('/chat', function () {

    return view('ai.chat');

});



Route::get('/ai', [AiController::class, 'index']);
Route::get('/questionanswer', [AiController::class, 'questionanswer']);
Route::get('/ai/companybg', [AiController::class, 'CompanyBackground']);
Route::get('/ai/operation/companybackground', [AiController::class, 'companyBackgroundAnalysis']);
