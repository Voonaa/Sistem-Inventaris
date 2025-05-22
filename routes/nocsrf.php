<?php

use App\Http\Controllers\Api\NocsrfAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Without CSRF Protection
|--------------------------------------------------------------------------
|
| These routes are specifically excluded from CSRF protection.
| They are intended for direct API access from external clients.
|
*/

// Test route to verify this file is loaded
Route::get('/api-login', function() { 
    return 'API Login test';
})->name('api-login');

// No CSRF auth route
Route::post('/auth/login', [NocsrfAuthController::class, 'login']); 