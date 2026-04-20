<?php

use App\Http\Middleware\ChekKepalaIT;
use App\Http\Middleware\ChekTeknisi;
use App\Http\Middleware\ChekUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'user' => ChekUser::class,
            'teknisi' => ChekTeknisi::class,
            'kepala_it' => ChekKepalaIT::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
