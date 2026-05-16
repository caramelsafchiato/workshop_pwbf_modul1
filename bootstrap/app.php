<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
// bootstrap/app.php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectUsersTo('/');

        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'isVendor' => \App\Http\Middleware\IsVendor::class, 
            'isSales'  => \App\Http\Middleware\IsSales::class,
        ]);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();