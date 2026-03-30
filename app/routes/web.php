<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['info' => 'this project is API'], 200);
});

Route::get('/', function () {
    return redirect('/api/doc');
});