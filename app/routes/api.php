<?php

use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json(['status' => 'connected'], 200);
});

require base_path('app/Domains/Auth/routes/api.php');

Route::middleware(['auth:sanctum', 'banned'])->group(function () {

    require base_path('app/Domains/Admin/routes/api.php');
    require base_path('app/Domains/Users/routes/api.php');
});

Route::fallback(function(){
    return response()->json(['this project is API']);
});