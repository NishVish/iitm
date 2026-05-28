<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\EventController;


Route::get('/api/events', [EventController::class, 'getUpcomingEvents']); // API-like route
Route::get('/events', [EventController::class, 'showevents']); // Blade page
Route::get('/lasteventdetails/{id?}', [EventController::class, 'lastEventDetails']);
Route::get('/register', [EventController::class, 'showevents'])->name('register');
