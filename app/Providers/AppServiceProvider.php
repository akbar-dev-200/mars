<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Example Gate: Allow access only if user has a verified email (just as a demo of Gates)
        \Illuminate\Support\Facades\Gate::define('view-profile', function ($user) {
            return $user->email_verified_at !== null; // Example logic
        });
    }
}
