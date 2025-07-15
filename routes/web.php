<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\V1\Whatsapp\Instances\ConnectWhatsappInstanceController;
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
    Route::post('/auth/login', LoginController::class);

    Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
        Route::get('/whatsapp/instances', ListInstancesController::class);
        Route::post('/whatsapp/instances', CreateInstanceController::class);
        Route::delete('/whatsapp/instances/{name}', DeleteInstanceController::class);

        Route::get('/whatsapp/instances/{name}/connect', ConnectInstanceController::class);
        Route::delete('/whatsapp/instances/{name}/logout', DisconnectInstanceController::class);
        Route::post('/whatsapp/instances/{name}/reload', ReloadInstanceController::class);

        Route::post('/whatsapp/messages/send', SendWhatsappMessageController::class);
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
