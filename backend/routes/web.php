<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs', function () {
    return response()->file(public_path('swagger-ui/index.html'));
});

Route::get('/docs-api', function () {
    return view('vendor/scalar/reference');
});
