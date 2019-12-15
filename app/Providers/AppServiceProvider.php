<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GameserverApp\Api\Client;
use GameserverApp\Api\Forum\Dispatcher;
use GameserverApp\Api\OAuthApi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);

        $this->app->singleton(OAuthApi::class, function($app) {
            return new OAuthApi();
        });

        $this->app->singleton(Client::class, function($app) {
            return new Client();
        });
    }
}
