<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\MailTestController;


Route::get('/Registrationcompletetemplate', [MailTestController::class, 'Registrationcomplete']);


Route::get('/mail-test', [MailTestController::class, 'index']);
Route::post('/mail-test/send', [MailTestController::class, 'send']);
