<?php

use App\Domains\Admin\Http\Controllers\AdminBanController;
use App\Domains\Admin\Http\Controllers\AdminController;
use App\Domains\Admin\Http\Controllers\AdminRoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')
    ->prefix('/admin')
    ->group(function () {

        Route::controller(AdminController::class)
            ->group(function () {
                Route::get('/users', 'getAllUsers');
                Route::get('/users/{id}', 'getUser');
                Route::patch('/users/{id}', 'updateUser');
                Route::delete('/users/{id}', 'deleteUser');
            });
        Route::controller(AdminBanController::class)
            ->group(function () {
                Route::patch('/users/{id}/ban',   'banUser');
                Route::patch('/users/{id}/unban',   'unBanUser');
            });
        Route::controller(AdminRoleController::class)
            ->group(function () {
                Route::patch('/users/{id}/promote', 'promoteUser');
                Route::patch('/users/{id}/demote', 'demoteUser');
            });
    });
