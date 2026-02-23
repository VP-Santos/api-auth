<?php

use App\Http\Middleware\AdmMiddleware;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'adm' => AdmMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return true;
        });

        $exceptions->render(function (RouteNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }
        });

        $exceptions->render(function (QueryException $e, $request) {
            Log::error('Erro de Banco de Dados: ' . $e->getMessage());

            return response()->json([
                'success'    => false,
                'code'      => 'DATABASE_ERROR',
                'message'   => 'A technical problem occurred...',
            ], 500);
        });
    })
    ->create();
