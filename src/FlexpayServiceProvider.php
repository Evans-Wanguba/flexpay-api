<?php
namespace EvansWanguba\Flexpay;

use Illuminate\Support\ServiceProvider;
use EvansWanguba\Flexpay\FlexpayClient;
use EvansWanguba\Flexpay\Contracts\FlexpayClientContract;

class FlexpayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flexpay.php', 'flexpay');

        $this->app->singleton(FlexpayClientContract::class, function ($app) {
            return new FlexpayClient($app['config']->get('flexpay'));
        });

        $this->app->alias(FlexpayClientContract::class, 'flexpay.client');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/flexpay.php' => config_path('flexpay.php'),
            ], 'flexpay-config');
        }
    }
}
