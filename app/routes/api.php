<?php

use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::get('/status', [StatusController::class, 'status']);

require base_path('app/Domains/Auth/routes/api.php');

Route::middleware(['auth:sanctum', 'banned'])->group(function () {

    require base_path('app/Domains/Admin/routes/api.php');
    require base_path('app/Domains/Users/routes/api.php');
});

Route::fallback(function () {
    return response()->json(['this project is API']);
});
