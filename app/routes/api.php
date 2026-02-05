<?php

use App\Http\Controllers\Auth\AdmController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['status' => 'connected'], 200);
});

Route::post('/register',    [AuthController::class, 'register'])->name('register.auth');
Route::post('/login',       [AuthController::class, 'login'])->name('login.auth');

Route::get('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/verify-twoFactor', [AuthController::class, 'verifyTwoFactor']);

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::get('/user', 'show');
        Route::put('/update', 'update');
        Route::delete('/logout', 'logout');
    });

    Route::middleware('adm')->controller(AdmController::class)->prefix('/adm')->group(function () {
        Route::get('/all-users', 'getAllUsers');
        Route::get('/get-user/{id}', 'getUser');
        Route::put('/update-user/{id}', 'updateUser');
        Route::delete('/delete-user/{id}', 'deleteUser');
    });
});
