<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;

Route::get('/cmd', function () {
    return view('cmd');
});

Route::post('/run-command', [CommandController::class, 'run'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/run-command', [CommandController::class, 'hello']);