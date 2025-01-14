<?php

use App\Http\Middleware\AdminLoginMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Providers\AppServiceProvider;
use App\Providers\RateLimiterServiceProvider;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        AppServiceProvider::class,
        RateLimiterServiceProvider::class
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'isLogin' => LoginMiddleware::class,
            'isAdminLogin' => AdminLoginMiddleware::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();
