<?php

use App\Domains\Admin\Middleware\AdminMiddleware;
use App\Http\Middleware\IsBannedMiddleware;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
            'admin' => AdminMiddleware::class,
            'banned' => IsBannedMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(fn($request, $e) => $request->is('api/*'));

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json([
                'success' => false,
                'error_code' => 'METHOD_NOT_ALLOWED',
                'message' => 'HTTP method not allowed for this route.',
            ], 405);
        });

        // $exceptions->render(function (RouteNotFoundException $e, Request $request) {
        //     return response()->json([
        //         'success' => false,
        //         'error_code' => 'ROUTE_NOT_FOUND',
        //         'message' => 'Route not found.',
        //     ], 404);
        // });

        $exceptions->render(function (QueryException $e, Request $request) {

            return response()->json([
                'success' => false,
                'error_code' => 'DATABASE_ERROR',
                'message' => 'A technical problem occurred.',
            ], 500);
        });

        // fallback genérico
        $exceptions->render(function (Throwable $e, Request $request) {

            return response()->json([
                'success' => false,
                'error_code' => 'UNEXPECTED_ERROR',
                'message' => 'An unexpected error occurred.',
            ], 500);
        });
    })
    ->create();
