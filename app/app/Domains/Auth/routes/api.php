<?php

use App\Domains\Auth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {

    Route::post('/register', 'register')->name('register.auth');
    Route::post('/login', 'login')->name('login.auth');
    Route::post('/verify-email',  'verifyEmail')->name('verify.auth');
    Route::post('/verify-twoFactor',  'verifyTwoFactor')->name('verifyTwoFactor.auth');
    Route::post('/forgot-password',  'forgotPassword')->name('forgotPassword.auth');
    Route::post('/reset-password',  'resetPassword')->name('resetPassword.auth');
    Route::post('/resend-token-password',  'resendTokenPassword')->name('resendTokenPassword.auth');
    Route::post('/resend-two-factor',  'resendTwoFactor')->name('resendTwoFactorEmail.auth');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::delete('/logout', 'logout');
    });
});


