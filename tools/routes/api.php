<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Assistant\AssistantController;

// Route::post('/assistant/ask/web', function () {
//     return response()->json([
//         "status" => true,
//         "answer" => '{"name":"John","email":"john@test.com","phone":"123456"}'
//     ]);
// });
require __DIR__ . '/mailapi.php';
require __DIR__ . '/ragapi.php';
require __DIR__ . '/registration/registrationapi.php';

Route::post('/assistant/ask/web', [AssistantController::class, 'ask']);
