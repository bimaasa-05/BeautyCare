<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

require_once __DIR__ . '/../vendor/laravel/socialite/src/SocialiteServiceProvider.php';

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('booking:reminder')->everyFiveMinutes();
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([     // Masukkan ini
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        \Laravel\Socialite\SocialiteServiceProvider::class,
    ])
    ->create();
