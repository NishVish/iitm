<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;




Route::get('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login');

Route::post('/admin/verify', [AdminController::class, 'verify'])
    ->name('admin.verify');

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index');

Route::get('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');

Route::get('/admin/tables', [AdminController::class, 'index'])
    ->name('admin.tables');
Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])
    ->name('admin.edit');


Route::put('/admin/update/{id}', [AdminController::class, 'update'])
    ->name('admin.update');


Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])
    ->name('admin.destroy');


Route::get('/admin/{location}/add', [AdminController::class, 'add'])
    ->name('admin.add');


Route::get('/admin/{location}', [AdminController::class, 'eventdetails'])
    ->name('admin.location');


Route::get('/admin/eventdetails/{location}/{event}', [AdminController::class, 'index'])
    ->name('admin.eventdetails');