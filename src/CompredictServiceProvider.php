<?php

namespace Compredict\Laravel;

use Compredict\API\Client as Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;


class CompredictServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(__DIR__).'/config/compredict.php';
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('compredict.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('compredict');
        }
        $this->mergeConfigFrom($source, 'compredict');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('compredict', function ($app) {
            $config = $app->make('config')->get('compredict');
            $compredict_client = Client::getInstance($config['key'], $config['callback']);
            $compredict_client->failOnError($config['fail_on_error']);
            return $compredict_client;
        });

        $this->app->alias('compredict', 'Compredict\API\Client');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['compredict', 'Compredict\API\Client'];
    }
}
