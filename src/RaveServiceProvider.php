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
        $this->bindVirtualAccount();
        $this->bindAccountPayment();
        $this->bindAchPayment();
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
            'laravelvirtualaccount',
            'laravelaccountpayment',
            'laravelachpayment',
        ];
    }

    private function bindRave()
    {
        $this->app->singleton('laravelrave', function ($app) {
            $secret_key = config('flutterwave.secret_key');
            $prefix = config('app.name');

            return new Rave($secret_key, $prefix);
        });

        $this->app->alias('laravelrave', "Laravel\Flutterwave\Rave");
    }

    private function bindVirtualAccount()
    {
        $this->app->singleton('laravelvirtualaccount', function ($app) {
            return new VirtualAccount;
        });

        $this->app->alias('laravelvirtualaccount', "Laravel\Flutterwave\VirtualAccount");
    }

    private function bindAccountPayment()
    {
        $this->app->singleton('laravelaccountpayment', function ($app) {
            return new Account;
        });

        $this->app->alias('laravelaccountpayment', "Laravel\Flutterwave\Account");
    }

    private function bindAchPayment()
    {
        $this->app->singleton('laravelachpayment', function ($app) {
            return new Ach;
        });

        $this->app->alias('laravelachpayment', "Laravel\Flutterwave\Ach");
    }
}
