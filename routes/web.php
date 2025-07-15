<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', \App\Http\Controllers\Api\V1\Auth\LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/whatsapp/messages/schedule', \App\Http\Controllers\Api\V1\ScheduleWhatsappMessageController::class);
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
