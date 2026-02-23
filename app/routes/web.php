<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['info' => 'this project is API'], 200);
});
