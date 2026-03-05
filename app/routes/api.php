<?php

use App\Http\Controllers\Auth\{
    AdmController,
    AuthController
};
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['status' => 'connected'], 200);
});

Route::controller(AuthController::class)->group(function () {

    Route::post('/register', 'register')->name('register.auth');
    Route::post('/login', 'login')->name('login.auth');
    Route::post('/verify-email',  'verifyEmail')->name('verify.auth');
    Route::post('/verify-twoFactor',  'verifyTwoFactor')->name('verifyTwoFactor.auth');
    Route::post('/forgot-password',  'forgotPassword')->name('forgotPassword.auth');
    Route::post('/reset-password',  'resetPassword')->name('resetPassword.auth');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::get('/user', 'show');
        Route::put('/update', 'update');
        Route::delete('/logout', 'logout');
         Route::post('/update-password',  'updatePassword')->name('updatePassword.auth');
    });

    Route::middleware('adm')->controller(AdmController::class)->prefix('/adm')->group(function () {
        Route::get('/all-users', 'getAllUsers');
        Route::get('/get-user/{id}', 'getUser');
        Route::put('/update-user/{id}', 'updateUser');
        Route::delete('/delete-user/{id}', 'deleteUser');
    });
});
