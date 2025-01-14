<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class RateLimiterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        RateLimiter::for('resetPasswordEmail', function (Request $request) {
            $key = $request->input('role') . '|' . $request->input('email');
            return Limit::perMinutes(30, 5)->by($key);
        });
    }
}
