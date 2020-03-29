<?php

namespace yedincisenol\Parasut\Laravel;

use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\Parasut;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Config assets publish
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/parasut.php' => config_path('parasut.php')
        ], 'parasut');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/parasut.php', 'parasut'
        );

        $this->app->singleton(Parasut::class, function ($app) {
            return new Client(
                array_get($app['config'], 'parasut.connection.client_id'),
                array_get($app['config'], 'parasut.connection.client_secret'),
                array_get($app['config'], 'parasut.connection.redirect_uri'),
                array_get($app['config'], 'parasut.connection.username'),
                array_get($app['config'], 'parasut.connection.password'),
                array_get($app['config'], 'parasut.connection.company_id'),
                array_get($app['config'], 'parasut.connection.is_stage')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Parasut::class];
    }
}
