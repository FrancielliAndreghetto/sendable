<?php

use App\Http\Controllers\Api\Auth\ApiKeys\CreateApiKeyController;
use App\Http\Controllers\Api\Auth\ApiKeys\DeleteApiKeyController;
use App\Http\Controllers\Api\Auth\ApiKeys\GetApiKeyController;
use App\Http\Controllers\Api\Auth\ApiKeys\ListApiKeysController;
use App\Http\Controllers\Api\Auth\ApiKeys\UpdateApiKeyController;
use App\Http\Controllers\Api\Auth\Authenticate\AuthenticateUserController;
use App\Http\Controllers\Api\Whatsapp\Contacts\CreateWhatsappContactController;
use App\Http\Controllers\Api\Whatsapp\Contacts\DeleteWhatsappContactController;
use App\Http\Controllers\Api\Whatsapp\Contacts\GetWhatsappContactController;
use App\Http\Controllers\Api\Whatsapp\Contacts\ListWhatsappContactsController;
use App\Http\Controllers\Api\Whatsapp\Contacts\UpdateWhatsappContactController;
use App\Http\Controllers\Api\Whatsapp\Instances\ConnectWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\CreateWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\DeleteWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\DisconnectWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\ListWhatsappInstancesController;
use App\Http\Controllers\Api\Whatsapp\Instances\ReloadWhatsappInstanceController;
use App\Http\Controllers\Api\Whatsapp\Instances\SyncWhatsappInstanceContactsController;
use App\Http\Controllers\Api\Whatsapp\Messages\CreateWhatsappMessageController;
use App\Http\Controllers\Api\Whatsapp\Messages\DeleteWhatsappMessageController;
use App\Http\Controllers\Api\Whatsapp\Messages\GetWhatsappMessageController;
use App\Http\Controllers\Api\Whatsapp\Messages\ListWhatsappMessagesController;
use App\Http\Controllers\Api\Whatsapp\Messages\UpdateWhatsappMessageController;
use App\Http\Middleware\AuthSanctumOrApiKey;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', AuthenticateUserController::class)->name('auth.login');

Route::prefix('whatsapp')->middleware([AuthSanctumOrApiKey::class])->name('whatsapp.')->group(function () {
    Route::prefix('instances')->name('instances.')->group(function () {
        Route::get('', ListWhatsappInstancesController::class)->name('index');
        Route::post('', CreateWhatsappInstanceController::class)->name('store');
        Route::delete('/{uuid}', DeleteWhatsappInstanceController::class)->name('destroy');

        Route::post('/connect/{uuid}', ConnectWhatsappInstanceController::class)->name('connect');
        Route::delete('/disconnect/{uuid}', DisconnectWhatsappInstanceController::class)->name('disconnect');
        Route::post('/reload/{uuid}', ReloadWhatsappInstanceController::class)->name('reload');
        Route::post('/syncContacts/{uuid}', SyncWhatsappInstanceContactsController::class)->name('syncContacts');
    });

    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('', ListWhatsappMessagesController::class)->name('index');
        Route::post('', CreateWhatsappMessageController::class)->name('store');
        Route::get('/{uuid}', GetWhatsappMessageController::class)->name('show');
        Route::put('/{uuid}', UpdateWhatsappMessageController::class)->name('update');
        Route::delete('/{uuid}', DeleteWhatsappMessageController::class)->name('destroy');
    });

    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('', ListWhatsappContactsController::class)->name('index');
        Route::post('', CreateWhatsappContactController::class)->name('store');
        Route::get('/{uuid}', GetWhatsappContactController::class)->name('show');
        Route::put('/{uuid}', UpdateWhatsappContactController::class)->name('update');
        Route::delete('/{uuid}', DeleteWhatsappContactController::class)->name('destroy');
    });
});

Route::prefix('keys')->middleware([AuthSanctumOrApiKey::class])->name('keys.')->group(function () {
    Route::get('', ListApiKeysController::class)->name('index');
    Route::post('', CreateApiKeyController::class)->name('store');
    Route::get('/{uuid}', GetApiKeyController::class)->name('show');
    Route::put('/{uuid}', UpdateApiKeyController::class)->name('update');
    Route::delete('/{uuid}', DeleteApiKeyController::class)->name('destroy');
});
