<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // FIX 3: Admin login — max 5 attempts per minute per IP
        // Prevents brute-force attacks on the admin password
        RateLimiter::for('admin-login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // FIX 4: Reviews — max 3 submissions per hour per IP
        // Prevents spam bots from flooding product reviews
        RateLimiter::for('review', function (Request $request) {
            return Limit::perHour(3)->by($request->ip());
        });
    }
}
