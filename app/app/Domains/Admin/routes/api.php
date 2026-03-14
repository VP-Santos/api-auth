<?php

use App\Domains\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('adm')->controller(AdminController::class)
    ->prefix('/admin')->group(function () {
        Route::get('/all-users', 'getAllUsers');
        Route::get('/get-user/{id}', 'getUser');
        Route::put('/update-user/{id}', 'updateUser');
        Route::delete('/delete-user/{id}', 'deleteUser');
        Route::put('/ban-user/{id}', 'banUser');
        Route::put('/promote-user/{id}', 'promoteUser');
    });
