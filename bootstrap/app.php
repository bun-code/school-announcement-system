<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ── Register AdminOnly middleware alias ──────────────
        $middleware->alias([
            'admin.only' => \App\Http\Middleware\AdminOnly::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        // ── Redirect unauthenticated users to admin login ────
        // Laravel's default redirects to route('login') which doesn't exist.
        // This overrides it to use route('admin.login') instead.
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('admin.login');
        });

    })->create();