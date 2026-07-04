<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ai\RagApi;

Route::get('/ai/rag/train', [RagApi::class, 'train']);
Route::get('/ai/rag/trainbylink/{link}', [RagApi::class, 'trainbylink']);
Route::match(['get', 'post'], '/ai/rag/ask', [RagApi::class, 'ask']);
Route::match(['get', 'post'], '/ai/rag/askdirect/{question}', [RagApi::class, 'askdirect']);
Route::get('/ai/rag/test', [RagApi::class, 'ragTest']);
Route::get('/ragapi', [RagApi::class, 'ragapi']);
Route::get('/ragresource', [RagApi::class, 'ragresource']);



