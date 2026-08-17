<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\RegisterController;


Route::post('/register', [RegisterController::class, 'store'])->name('register.store'); // submit login


Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');
// This is your current GET route that shows the form
Route::get('/registration/form', [RegisterController::class, 'registration_form'])->name('registration.form');
Route::get('/register-now', [RegisterController::class, 'register_now'])->name('register.now');
Route::post('/upload-logo', [RegisterController::class, 'uploadLogo']);
// ADD THIS ROUTE BELOW:
Route::post('/registration/submit', [RegisterController::class, 'registaritonsubmit'])->name('registration.submit');
Route::get('/category/{nameofthecompany}', [RegisterController::class, 'category'])->name('category');
Route::post('/enquiry', [RegisterController::class, 'register_enquiry'])->name('enquiry');
Route::get('/register_enquiry', [RegisterController::class, 'register_enquiry'])->name('register_enquiry');
Route::get('/emailtemplate', [RegisterController::class, 'emailtemplate'])->name('emailtemplate');
// Route::get('/register/{location}', [RegisterController::class, 'index'])->name('register');


Route::get('/Registrationcompletetemplate', [RegisterController::class, 'registrationsuccestemplate']);
