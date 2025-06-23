<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Parse request path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Define MIME types for static assets
$mimeTypes = [
    'css' => 'text/css; charset=UTF-8',
    'js' => 'application/javascript; charset=UTF-8',
    'json' => 'application/json; charset=UTF-8',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'svg' => 'image/svg+xml',
    'ico' => 'image/x-icon',
    'txt' => 'text/plain; charset=UTF-8',
    'pdf' => 'application/pdf',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf' => 'font/ttf',
    'eot' => 'application/vnd.ms-fontobject'
];

// Check if request is for a static file
if (preg_match('/\.(' . implode('|', array_keys($mimeTypes)) . ')$/', $path, $matches)) {
    $extension = $matches[1];
    $filePath = __DIR__ . '/../public' . $path;

    // Check if file exists
    if (file_exists($filePath)) {
        header('Content-Type: ' . $mimeTypes[$extension]);
        header('Cache-Control: public, max-age=31536000, immutable');
        readfile($filePath);
        exit;
    }

    // If file doesn't exist, return 404
    header('HTTP/1.1 404 Not Found');
    exit('File not found.');
}

// For PHP requests, set default content type
header('Content-Type: text/html; charset=UTF-8');

// Handle PHP request
require __DIR__ . '/../public/index.php'; 