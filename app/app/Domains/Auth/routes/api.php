<?php

use App\Domains\Auth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::middleware('banned')->group(function () {

        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/email/verify', [AuthController::class, 'verifyEmail'])->name('auth.verifyEmail');
        Route::post('/two-factor/verify', [AuthController::class, 'verifyTwoFactor'])->name('auth.verifyTwoFactor');
        Route::post('/password/forgot', [AuthController::class, 'forgotPassword'])->name('auth.forgotPassword');
        Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('auth.resetPassword');
        Route::post('/password/resend-token', [AuthController::class, 'resendTokenPassword'])->name('auth.resendTokenPassword');
        Route::post('/two-factor/resend', [AuthController::class, 'resendTwoFactor'])->name('auth.resendTwoFactor');


        Route::middleware('auth:sanctum')->group(function () {
            Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        });
    });
});
