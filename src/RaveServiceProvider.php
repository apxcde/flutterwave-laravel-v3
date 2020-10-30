<?php

namespace Laravel\Flutterwave;

use Illuminate\Support\ServiceProvider;

class RaveServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__.'/config/flutterwave.php');

        $this->publishes([
            $config => config_path('flutterwave.php')
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindRave();
    }

    /**
    * Get the services provided by the provider
    *
    * @return array
    */
    public function provides()
    {
        return [
            'laravelrave',
        ];
    }

    private function bindRave()
    {
        $this->app->singleton('laravelrave', function ($app) {
            return new Rave(env('FLUTTERWAVE_SECRET_KEY'));
        });

        $this->app->alias('laravelrave', "Laravel\Flutterwave\Rave");
    }
}