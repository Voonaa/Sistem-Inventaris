<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register 'role' in the container to prevent Laravel from treating it as a class
        $this->app->bind('role', function($app) {
            return new \App\Http\Middleware\CheckUserRole;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
