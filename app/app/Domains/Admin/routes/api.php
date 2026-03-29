<?php

use App\Domains\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->controller(AdminController::class)
    ->prefix('/admin')->group(function () {
        Route::get('/users', 'getAllUsers');
        Route::get('/users/{id}', 'getUser');
        Route::patch('/users/{id}', 'updateUser');
        Route::delete('/users/{id}', 'deleteUser');
        Route::patch('/users/{id}/ban',   'banUser');
        Route::patch('/users/{id}/unban',   'unBanUser');
        Route::patch('/users/{id}/promote', 'promoteUser');
        Route::patch('/users/{id}/demote', 'demoteUser');
    });
