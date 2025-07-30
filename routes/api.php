<?php

use App\Http\Controllers\Api\Auth\ApiKeys\CreateApiKeyController;
use App\Http\Controllers\Api\Auth\ApiKeys\DeleteApiKeyController;
use App\Http\Controllers\Api\Auth\ApiKeys\GetApiKeyController;
use App\Http\Controllers\Api\Auth\ApiKeys\ListApiKeysController;
use App\Http\Controllers\Api\Auth\ApiKeys\UpdateApiKeyController;
use App\Http\Controllers\Api\Auth\Authenticate\AuthenticateUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Whatsapp\Instances\ConnectWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\CreateWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\DeleteWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\DisconnectWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\ListWhatsappInstancesController;
use App\Http\Controllers\Api\Whatsapp\Instances\ReloadWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Messages\SendWhatsappMessageController;
use App\Http\Middleware\AuthSanctumOrApiKey;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', AuthenticateUserController::class);

Route::prefix('whatsapp')->middleware([AuthSanctumOrApiKey::class])->group(function () {
    Route::get('/instances', ListWhatsappInstancesController::class);
    Route::post('/instances', CreateWhatsappInstanceController::class);
    Route::delete('/instances/{uuid}', DeleteWhatsappInstanceController::class);

    Route::post('/instances/connect/{uuid}', ConnectWhatsappInstanceController::class);
    Route::delete('/instances/disconnect/{uuid}', DisconnectWhatsappInstanceController::class);
    Route::post('/instances/reload/{uuid}', ReloadWhatsappInstanceController::class);

    Route::post('/messages/send', SendWhatsappMessageController::class);
});

Route::prefix('keys')->middleware([AuthSanctumOrApiKey::class])->group(function () {
    Route::get('', ListApiKeysController::class);
    Route::post('', CreateApiKeyController::class);
    Route::get('/{uuid}', GetApiKeyController::class);
    Route::delete('/{uuid}', DeleteApiKeyController::class);
    Route::put('/{uuid}', UpdateApiKeyController::class);
});
