<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check for maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Try local path first, then hosting path for vendor autoload
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
} else if (file_exists(__DIR__.'/../inventaris-smk-sasmita/vendor/autoload.php')) {
    require __DIR__.'/../inventaris-smk-sasmita/vendor/autoload.php';
}

// Try local path first, then hosting path for bootstrap
if (file_exists(__DIR__.'/../bootstrap/app.php')) {
    $app = require_once __DIR__.'/../bootstrap/app.php';
} else if (file_exists(__DIR__.'/../inventaris-smk-sasmita/bootstrap/app.php')) {
    $app = require_once __DIR__.'/../inventaris-smk-sasmita/bootstrap/app.php';
}

// Run The Application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
