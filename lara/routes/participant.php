<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ParticipantController;


Route::get('/exhibiting', [ParticipantController::class, 'index'])->name('exhibiting');
Route::get('/attending', [ParticipantController::class, 'index'])->name('attending');
Route::get('/enquiry', [ParticipantController::class, 'enquriyform'])->name('enquiry');
// Route::post('/visitor-form', [ParticipantController::class, 'fetchentity'])->name('visitor-form');
