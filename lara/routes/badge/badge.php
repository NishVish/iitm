<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Badge\ExhibitorController;

// Route::post('/assistant/ask/web', function () {
//     return response()->json([
//         "status" => true,
//         "answer" => '{"name":"John","email":"john@test.com","phone":"123456"}'
//     ]);
// });


// routes/web.php

Route::post('/editdata/entry', [ExhibitorController::class, 'editdata'])
    ->name('showdata.save');
	
Route::get('/showdata/{id}', [ExhibitorController::class, 'index']);
Route::get('/editdata/{id}', [ExhibitorController::class, 'secret']);

Route::post('/showdata/save', [ExhibitorController::class, 'save'])
    ->name('showdata.save');
	
	// routes/web.php
Route::get('/visitor/{key}/vcard', [ExhibitorController::class, 'vcard'])->name('visitor.vcard');



	