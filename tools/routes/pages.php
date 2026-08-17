<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\InfopagesController;


Route::get('/contactus', [InfopagesController::class, 'contactus'])->name('contactus');
Route::get('/aboutus', [InfopagesController::class, 'aboutus'])->name('aboutus');
Route::get('/resourcepage', [InfopagesController::class, 'resourcepage'])->name('resourcepage');
Route::get('/resourceinventory', [InfopagesController::class, 'resourceinventory'])->name('resourceinventory');
Route::get('/gallery', [InfopagesController::class, 'gallery'])->name('gallery');
Route::get('/faq', [InfopagesController::class, 'gallery'])->name('gallery');
