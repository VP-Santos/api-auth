<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['info' => 'this project is API'], 200);
});

Route::get('/verify-email', function () {
    return view('web.verifyEmail');
});
Route::controller(WebController::class)->group(function(){
    Route::get('/', 'home')->name('homepage');
    Route::get('/register', 'register')->name('register.web');
    Route::post('/form-register', 'formRegister')->name('formRegister.web');
    Route::get('/login', 'login')->name('login.web');
    Route::get('/forgot-password', 'forgotPassword')->name('forgotPassword.web');
    Route::get('/reset-password', 'resetPassword')->name('resetPassword.web');
});
