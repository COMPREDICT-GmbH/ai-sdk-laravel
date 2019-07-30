<?php

namespace Compredict\Algorithm;

use Compredict\API\Algorithms\Client as Client;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class CompredictServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('compredict_algo', function ($app) {
            $config = $app->make('config')->get('compredict');
            $config_algo = $config['ai_core'];
            $compredict_client = Client::getInstance($config_algo['key'], $config_algo['callback'], $config_algo['ppk'], $config_algo['passphrase']);
            $compredict_client->failOnError($config_algo['fail_on_error']);
            return $compredict_client;
        });

        $this->app->alias('CP_Algo', 'Compredict\API\Algorithms\Client');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(__DIR__) . '/config/compredict.php';
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('compredict.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('compredict');
        }
        $this->mergeConfigFrom($source, 'compredict');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['compredict_algo', 'Compredict\API\Algorithms\Client'];
    }
}
