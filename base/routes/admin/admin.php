<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CRUD\UpdateData\UpdateDataController;
use Illuminate\Support\Facades\Route;



Route::get('admin', [AdminController::class, 'login'])
    ->name('admin.login');


Route::get('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login');

Route::post('/admin/verify', [AdminController::class, 'verify'])
    ->name('admin.verify');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');

Route::get('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');


Route::get('/admin/payment/request', [AdminController::class, 'paymentRequest'])
    ->name('admin.payment.request');


Route::get('/admin/payment-request', [AdminController::class, 'paymentRequest'])
    ->name('admin.paymentRequest');



Route::post('/admin/paymentstatusupdate', [UpdateDataController::class, 'paymentStatusUpdate'])
    ->name('admin.paymentRequest');



Route::get('/admin/payment/logs', [AdminController::class, 'paymentLogs'])
    ->name('admin.payment.logs');


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