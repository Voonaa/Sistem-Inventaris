<?php

// Create required directories
if (!file_exists('/tmp/storage')) {
    mkdir('/tmp/storage', 0777, true);
}

if (!file_exists('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// Create SQLite database if it doesn't exist
if (!file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
    chmod('/tmp/database.sqlite', 0777);
}

// For static files, serve from public directory
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

// For non-static files, proxy to Laravel
require __DIR__ . '/../public/index.php'; 