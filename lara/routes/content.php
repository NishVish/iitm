<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ContentController;


Route::get('/keyhighlights', [ContentController::class, 'keyhighlights'])->name('keyhighlights');
