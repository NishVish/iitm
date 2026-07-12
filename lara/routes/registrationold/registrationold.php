<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Registrationold\RegistrationoldController;


Route::get('registration/{type}/{type}/{location}', [RegistrationController::class, 'form']);





