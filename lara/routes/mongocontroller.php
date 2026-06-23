<?php

use Illuminate\Support\Facades\Route;









use App\Http\MongoController\MongoController;


Route::get('/mongo', [MongoController::class, 'index']);
Route::post('/mongo/store', [MongoController::class, 'store']);// Route::get('/mail/massmail', [MailController::class, 'MassMailDashboard']);
