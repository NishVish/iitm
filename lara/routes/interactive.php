<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\InteracitveController;


Route::get('/interactive', [InteracitveController::class, 'index'])->name('interactive');
Route::get('/stalldemo', [InteracitveController::class, 'stalldemo'])->name('stalldemo');
Route::get('/reload', [InteracitveController::class, 'reload'])->name('reload');


Route::post('/upload-logo', [InteracitveController::class, 'uploadLogo'])->name('upload.logo');
Route::get('/clear-session', [InteracitveController::class, 'clearSession'])->name('session.clear');
Route::get('/blender-info', [InteracitveController::class, 'blender_info']);
