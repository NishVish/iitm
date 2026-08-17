<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\Tools\BadgeController;
use App\Http\Controllers\Tools\Tools;

Route::get('tools', [Tools::class, 'index']);

Route::get('scanner/{name}', [Tools::class, 'ocr']);

Route::get('lookup', [Tools::class, 'ocr']);
Route::post('lookup', [Tools::class, 'ocr']);
Route::post('ocr/lookup', [Tools::class, 'ocr'])->name('ocr.lookup');
Route::post('ocr/save', [Tools::class, 'saveOcr'])->name('ocr.save');
Route::get('ocrdata/{name}', [Tools::class, 'list'])->name('list.list');
Route::post('ocrdata/update', [Tools::class, 'update'])->name('update.update');
Route::get('ocrdata/update/{name}', [Tools::class, 'update'])->name('documents.update');
Route::get('ocrdata/destroy/{id}', [Tools::class, 'destroy'])->name('documents.destroy');


Route::get('badgesystem', [BadgeController::class, 'index']);
Route::get('getDataforbadge/{input?}', [BadgeController::class, 'getDataforbadge']);
Route::get('getDataforbadge', [BadgeController::class, 'getDataforbadge']);
Route::get('badgescanner', [BadgeController::class, 'badgescanner']);
Route::post('decodeqr/{id}', [BadgeController::class, 'decodeqr']);
Route::get('decodeqr/{id}', [BadgeController::class, 'decodeqr']);

Route::get('badgescanner/{id}', [BadgeController::class, 'badgescanner']);
Route::get('printbadges/{id}', [BadgeController::class, 'badgeprinter']);
Route::get('gettheontect/{id}/{query}', [BadgeController::class, 'gettheontect']);// Route::post('/assign-lead', [AdminController::class, 'assignlead'])->name('assign.lead');


