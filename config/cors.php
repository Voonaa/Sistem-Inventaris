<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'test-connection', '*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        'https://NAMA-VERCEL-APP.vercel.app', // Ganti dengan domain frontend Vercel Anda
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
]; 