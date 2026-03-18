<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Check maintenance mode (Corrected Path)
$maintenance = __DIR__ . '/storage/framework/maintenance.php';
if (file_exists($maintenance)) {
    require $maintenance;
}

// 2. Load Composer autoloader (Corrected Path - No '../')
require __DIR__ . '/vendor/autoload.php';

// 3. Bootstrap the application (Corrected Path - No '../')
$app = require_once __DIR__ . '/bootstrap/app.php';

// --- REMOVE THE DEBUG ECHO LINE HERE ---

// 4. Handle the Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);