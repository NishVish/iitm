<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\Web\GalleryController;

Route::get('/gallerydata', [GalleryController::class, 'gallery'])->name('gallery');
