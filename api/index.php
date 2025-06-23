<?php

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Handle static files
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Define MIME types for common static files
$mimeTypes = [
    'css' => 'text/css',
    'js' => 'application/javascript',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif' => 'image/gif',
    'svg' => 'image/svg+xml',
    'ico' => 'image/x-icon',
    'pdf' => 'application/pdf',
    'woff' => 'font/woff',
    'woff2' => 'font/woff2',
    'ttf' => 'font/ttf',
    'eot' => 'application/vnd.ms-fontobject',
];

$publicPath = __DIR__ . '/../public';
$filePath = realpath($publicPath . $uri);

// Security check to prevent directory traversal
if ($filePath && strpos($filePath, $publicPath) === 0 && is_file($filePath)) {
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    if (isset($mimeTypes[$ext])) {
        header("Content-Type: {$mimeTypes[$ext]}");
        readfile($filePath);
        exit;
    }
}

// For non-static files, proxy to Laravel
require __DIR__ . '/../public/index.php'; 