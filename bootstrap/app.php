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
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan Alias Middleware di sini
        $middleware->alias([
            'role.applicant' => \App\Http\Middleware\EnsureUserCanApplyLeave::class,
            'role.approver'  => \App\Http\Middleware\EnsureUserIsApprover::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();