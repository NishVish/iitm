<?php

use Illuminate\Support\Facades\Route;


// require __DIR__ . '/ai.php';

require __DIR__ . '/admin.php';
require __DIR__ . '/assets.php';
require __DIR__ . '/assistant.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/backend.php';
require __DIR__ . '/badge.php';
require __DIR__ . '/booking.php';
require __DIR__ . '/category.php';
require __DIR__ . '/content.php';
require __DIR__ . '/cmd.php';
require __DIR__ . '/centraldatabase.php';
require __DIR__ . '/data.php';
require __DIR__ . '/database.php';
require __DIR__ . '/download.php';
require __DIR__ . '/events.php';
require __DIR__ . '/exhibitor.php';
require __DIR__ . '/gallery.php';
require __DIR__ . '/highlights.php';
require __DIR__ . '/hr.php';
require __DIR__ . '/interactive.php';
require __DIR__ . '/internal.php';
require __DIR__ . '/mailer.php';
require __DIR__ . '/mail.php';
require __DIR__ . '/mailtest.php';
require __DIR__ . '/mcp.php';
require __DIR__ . '/mongocontroller.php';
require __DIR__ . '/layout.php';
require __DIR__ . '/pages.php';
require __DIR__ . '/participant.php';
require __DIR__ . '/promotion.php';
require __DIR__ . '/payments.php';
require __DIR__ . '/programs.php';
require __DIR__ . '/ragcontroller.php';
require __DIR__ . '/ray.php';
require __DIR__ . '/register.php';
require __DIR__ . '/sales.php';
require __DIR__ . '/tools.php';
require __DIR__ . '/user.php';
require __DIR__ . '/utility.php';


use App\Http\Controllers\WebController;

// Route::get('/', [HomeController::class, 'index'])->name('home'); // show login form
Route::get('/', [WebController::class, 'index'])->name('web'); // show login form



Route::get('/csrf-test', function () {

    session()->regenerateToken();

    return [
        'session_id' => session()->getId(),
        'session_token' => session()->token(),
        'csrf_token' => csrf_token(),
    ];
});

use MongoDB\Client;

Route::get('/mongo-test', function () {

    $client = new Client("mongodb://127.0.0.1:27017");

    $db = $client->testdb;

    $db->users->insertOne([
        'name' => 'Test User',
        'created_at' => now()->toDateTimeString()
    ]);

    return $db->users->find()->toArray();
});