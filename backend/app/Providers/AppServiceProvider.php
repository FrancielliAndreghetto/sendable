<?php

namespace App\Providers;

use App\Models\WhatsappMessage;
use App\Observers\WhatsappMessageObserver;
use App\Services\Auth\ApiKeyGeneratorService;
use App\Services\Auth\AuthService;
use App\Services\Auth\Contracts\ApiKeyGeneratorServiceInterface;
use App\Services\Auth\Contracts\AuthServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ApiKeyGeneratorServiceInterface::class, ApiKeyGeneratorService::class);
    }

    public function boot(): void
    {
        WhatsappMessage::observe(WhatsappMessageObserver::class);
    }
}
