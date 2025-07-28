<?php

namespace App\Providers;

use App\Repositories\Contracts\Auth\ApiKeyRepositoryInterface;
use App\Repositories\Contracts\Auth\AuthTokenRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Instances\WhatsappInstanceRepositoryInterface;
use App\Repositories\Contracts\Whatsapp\Messages\WhatsappMessageRepositoryInterface;
use App\Repositories\Eloquent\Auth\ApiKeyRepository;
use App\Repositories\Eloquent\Auth\AuthTokenRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\Whatsapp\Instances\WhatsappInstanceRepository;
use App\Repositories\Eloquent\Whatsapp\Messages\WhatsappMessageRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            WhatsappMessageRepositoryInterface::class,
            WhatsappMessageRepository::class
        );

        $this->app->bind(
            WhatsappInstanceRepositoryInterface::class,
            WhatsappInstanceRepository::class
        );

        $this->app->bind(
            ApiKeyRepositoryInterface::class,
            ApiKeyRepository::class
        );

        $this->app->bind(
            AuthTokenRepositoryInterface::class,
            AuthTokenRepository::class
        );
    }
}
