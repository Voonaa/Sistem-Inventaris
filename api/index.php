<?php

// Set proper content type based on file extension
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$ext = pathinfo($path, PATHINFO_EXTENSION);

$mime_types = [
    'css' => 'text/css',
    'js' => 'application/javascript',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'svg' => 'image/svg+xml',
    'ico' => 'image/x-icon',
];

if (isset($mime_types[$ext])) {
    header('Content-Type: ' . $mime_types[$ext]);
} else {
    header('Content-Type: text/html; charset=UTF-8');
}

// Handle PHP requests
require __DIR__ . '/../public/index.php'; 