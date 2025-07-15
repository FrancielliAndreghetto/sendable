<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Contracts\Whatsapp\WhatsappMessageRepositoryInterface::class,
            \App\Repositories\Eloquent\Whatsapp\WhatsappMessageRepository::class
        );
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
