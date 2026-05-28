<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\HighlightsController;


Route::get('/highlights-imgaes', [HighlightsController::class, 'imgaes']);
Route::get('/getHighlights/{type}', [HighlightsController::class, 'getHighlights']);


Route::get('/highlights/create', [HighlightsController::class, 'create']);


// Route::get('/highlights/edit/{type}/{id}', [HighlightsController::class, 'edit']);


Route::post('/highlights-store', [HighlightsController::class, 'store']);


Route::get('/highlightpage-edit/{type?}', [HighlightsController::class, 'highlightpageedit']);


Route::put('/highlights/{id}', [HighlightsController::class, 'update']);


Route::delete('/highlights/{id}', [HighlightsController::class, 'destroy']);
