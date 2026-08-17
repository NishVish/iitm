<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\BadgeController;


Route::get('/badge-preview', [BadgeController::class, 'badgepreview']);


Route::get('/download-badge', [BadgeController::class, 'downloadBadge']);
route::get('generatebadge/{companyid}/{contactid}/{database}', [BadgeController::class, 'generatebadge']);
