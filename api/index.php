<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Parse request path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico)$/', $path)) {
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'ico' => 'image/x-icon'
    ];
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    header('Content-Type: ' . $mimeTypes[$extension]);
    readfile(__DIR__ . '/../public' . $path);
    exit;
}

// For PHP requests, set default content type
header('Content-Type: text/html; charset=UTF-8');

// Handle PHP request
require __DIR__ . '/../public/index.php'; 