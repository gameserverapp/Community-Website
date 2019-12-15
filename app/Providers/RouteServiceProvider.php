<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapAuthRoutes();

        $this->mapForumRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapForumRoutes()
    {
        Route::group([
            'namespace' => 'Riari\Forum\Http\Controllers',
            'as' => config('forum.routing.as'),
            'prefix' => config('forum.routing.root')
        ], function ($r) {
            include base_path('routes/forum.php');
        });
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    protected function mapAuthRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'namespace'  => $this->namespace . '\Auth'
        ], function ($router) {

            $router->get('/auth/login', [
                'as'         => 'auth.login',
                'uses'       => 'AuthController@login',
                'middleware' => 'guest'
            ]);

            $router->get('/auth/callback', [
                'as'         => 'auth.callback',
                'uses'       => 'AuthController@callback',
                'middleware' => 'guest'
            ]);

            $router->get('/auth/restricted', [
                'as'         => 'auth.restricted',
                'uses'       => 'AuthController@restricted',
                'middleware' => 'guest'
            ]);

            $router->get('/auth/disabled', [
                'as'         => 'auth.disabled',
                'uses'       => 'AuthController@disabled',
                'middleware' => 'auth'
            ]);

            $router->get('/auth/logout', [
                'as'         => 'auth.logout',
                'uses'       => 'AuthController@logout',
                'middleware' => 'auth'
            ]);
        });
    }
}
