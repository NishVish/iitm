<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });




use App\Http\Controllers\Internal\InternalController;

Route::get('/internal', [InternalController::class, 'index'])->name('internal.index');

Route::get('/internal/login', function () {
    return view('internal.login');
})->name('internal.login');

Route::post('/internal/login', [InternalController::class, 'login'])
    ->name('internal.login.submit');

Route::get('/internal/logout', [InternalController::class, 'logout'])
    ->name('internal.logout');


Route::get('/internal/knowledge', [InternalController::class, 'knowledge'])->name('internal.knowledge');
