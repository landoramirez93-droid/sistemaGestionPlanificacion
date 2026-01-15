<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias de middlewares (reemplaza Kernel.php en Laravel 11/12)
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        // Si necesitas agregar middleware global o grupos, sería aquí.
        // Ejemplo:
        // $middleware->append(\App\Http\Middleware\SomeGlobalMiddleware::class);
        // $middleware->group('web', [ ... ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Manejo de excepciones (opcional)
    })
    ->create();