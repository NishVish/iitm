<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ai\RagApi;

Route::get('/ai/rag/update-data', [RagApi::class, 'updateData']);
Route::match(['get', 'post'], '/ai/rag/ask', [RagApi::class, 'ask']);
Route::get('/ai/rag/test', [RagApi::class, 'ragTest']);
Route::get('/ragapi', [RagApi::class, 'ragapi']);
