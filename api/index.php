<?php

// Report all PHP errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// For static files
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Define MIME types
$mime_types = [
    'css' => 'text/css',
    'js' => 'application/javascript',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'ico' => 'image/x-icon',
    'svg' => 'image/svg+xml',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf' => 'font/ttf',
    'eot' => 'application/vnd.ms-fontobject',
];

// Check if the request is for a static file
$extension = pathinfo($uri, PATHINFO_EXTENSION);
if (isset($mime_types[$extension])) {
    $file = __DIR__ . '/../public' . $uri;
    if (file_exists($file)) {
        header('Content-Type: ' . $mime_types[$extension]);
        header('Cache-Control: public, max-age=31556952, immutable');
        readfile($file);
        exit;
    }
}

// For all other requests, proxy to Laravel
require __DIR__ . '/../public/index.php'; 