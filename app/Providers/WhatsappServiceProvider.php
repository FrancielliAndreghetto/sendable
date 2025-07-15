<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Whatsapp\WhatsappProviderInterface;
use App\Services\Whatsapp\WhatsappProvider;

class WhatsappServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WhatsappProviderInterface::class, WhatsappProvider::class);
    }
}
