<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['info' => 'this project is API'], 200);
});

Route::get('/reset', function () {
    return view('resetPassword');
})->name('reset-view');

Route::controller(WebController::class)->group(function(){
    Route::get('/', 'home')->name('homepage');
    Route::get('/register', 'register')->name('register')->name('register');
    Route::get('/login', 'home')->name('login')->name('login');
});
