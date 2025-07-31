<?php

namespace App\Providers;

use App\Services\Whatsapp\Contracts\WhatsappInstanceServiceInterface;
use App\Services\Whatsapp\Contracts\WhatsappMessageServiceInterface;
use App\Services\Whatsapp\WhatsappInstanceService;
use App\Services\Whatsapp\WhatsappMessageService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class WhatsappServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client();
        });

        $this->app->singleton(WhatsappMessageServiceInterface::class, WhatsappMessageService::class);
        $this->app->singleton(WhatsappInstanceServiceInterface::class, WhatsappInstanceService::class);
    }
}
