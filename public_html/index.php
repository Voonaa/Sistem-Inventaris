<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

// Check for maintenance mode
if (file_exists(__DIR__.'/../inventaris-smk-sasmita/storage/framework/maintenance.php')) {
    require __DIR__.'/../inventaris-smk-sasmita/storage/framework/maintenance.php';
}

// Register The Auto Loader
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require __DIR__.'/vendor/autoload.php';
} else {
    require __DIR__.'/../inventaris-smk-sasmita/vendor/autoload.php';
}

// Bootstrap Laravel Application
$app = require_once __DIR__.'/../inventaris-smk-sasmita/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response); 