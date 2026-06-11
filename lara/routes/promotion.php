<?php

use Illuminate\Support\Facades\Route;
// Route::get('/', function () {
//     return view('welcome');
// });




use App\Http\Controllers\Web\PromotionController;

Route::get('/promotion/{location}/{eventid}', [PromotionController::class, 'index'])->name('promotion');
Route::get('/promotion/list', [PromotionController::class, 'list'])->name('promotion.list');