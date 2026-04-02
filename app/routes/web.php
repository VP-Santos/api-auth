<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['info' => 'this project is API'], 200);
});

Route::get('/', function () {
    return redirect('/api/doc');
});
Route::get('/', function () {
    return redirect('/api/doc');
});
Route::get('/verify/email', function () {
    return request()->query('token');
});
Route::get('/reset/password', function () {
    return request()->query('token');
});

