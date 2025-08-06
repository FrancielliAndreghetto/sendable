<?php

namespace App\Providers;

use App\Repositories\Contracts\Whatsapp\Contacts\WhatsappContactRepositoryInterface;
use App\Repositories\Eloquent\Whatsapp\Contacts\WhatsappContactRepository;
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
        $this->app->bind(WhatsappContactRepositoryInterface::class, WhatsappContactRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
