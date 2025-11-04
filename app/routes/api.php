<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['status' => 'connected'], 200);
});

Route::controller(AuthController::class)->group(function () {

    Route::post('/register', 'register')->name('register.auth');
    Route::post('/login', 'login')->name('login.auth');
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'show');
        Route::post('/update', 'update');
        Route::post('/logout', 'logout');
    });
    
    Route::get('/users', 'showUsers')->middleware('adm');
});

