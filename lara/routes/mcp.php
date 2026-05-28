<?php

use Illuminate\Support\Facades\Route;
// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\MCPController;

Route::get('/mcp/users', [MCPController::class, 'getUsers']);