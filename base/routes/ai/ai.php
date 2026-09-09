<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ai\Ai;

Route::get('/ai', [Ai::class, 'index'])->name('ai.index');
Route::post('/ai/respond', [Ai::class, 'airespond'])->name('ai.respond');
Route::get('/ai/{message}', [Ai::class, 'respond'])->name('ai.respond');
