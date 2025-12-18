<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckPremiumAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Alias Middleware Kamu
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'premium.check' => CheckPremiumAccess::class,
        ]);

        // 2. Disable CSRF (Opsional jika pakai api.php, tapi aman ditambahkan)
        $middleware->validateCsrfTokens(except: [
            'api/midtrans-notification', // Sesuai route di api.php
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();