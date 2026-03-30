<?php

use App\Domains\Users\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->controller(UserController::class)->group(function () {

    Route::get('/me', 'me')->name('users.showMe');
    Route::patch('/me', 'updateMe')->name('users.updateMe');
    Route::patch('/me/password', 'updatePassword')->name('users.updatePassword');
    Route::delete('/me', 'deleteMe')->name('users.deleteMe');
});
