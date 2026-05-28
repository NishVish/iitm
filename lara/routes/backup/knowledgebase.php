<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });




use App\Http\Controllers\Web\KnowledgeBaseController;

Route::get('knowledgebase', [KnowledgeBaseController::class, 'index']);

