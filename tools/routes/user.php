<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\UserController;


route::get('/userdata', [UserController::class, 'userdata']);
