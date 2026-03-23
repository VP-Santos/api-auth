<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['info' => 'this project is API'], 200);
});

Route::get('/verify-email', function () {
    return request()->query('token', '');
});

Route::controller(WebController::class)->group(function(){
    Route::get('/', 'home')->name('homepage');
    Route::get('/register', 'register')->name('register');
    Route::post('/form-register', 'formRegister')->name('formRegister');
    Route::get('/forgot-password', 'forgotPassword')->name('forgotPassword');
    Route::get('/reset-password', 'resetPassword')->name('resetPassword');
});
