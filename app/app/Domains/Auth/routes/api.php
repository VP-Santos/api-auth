<?php

use App\Domains\Auth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::middleware('banned')->group(function () {

        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/email/verify', [AuthController::class, 'verifyEmail'])->name('verifyEmail');
        Route::post('/two-factor/verify', [AuthController::class, 'verifyTwoFactor'])->name('verifyTwoFactor');
        Route::post('/password/forgot', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
        Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/password/resend-token', [AuthController::class, 'resendTokenPassword'])->name('resendTokenPassword');
        Route::post('/two-factor/resend', [AuthController::class, 'resendTwoFactor'])->name('resendTwoFactor');


        Route::middleware('auth:sanctum')->group(function () {
            Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
        });
    });
});
