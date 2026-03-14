<?php

use App\Domains\Users\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {

    Route::get('/me', 'me')->name('show-me');
    Route::put('/update', 'update')->name('update-user');
    Route::put('/update-password',  'updatePassword')->name('updatePassword.user');
    Route::delete('/delete', 'deleteMe')->name('delete-user');
});
