<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use GameserverApp\Extensions\PremiumGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('premium', function ($app, $name, array $config) {
            return new PremiumGuard(Auth::createUserProvider($config['provider']));
        });
    }
}
