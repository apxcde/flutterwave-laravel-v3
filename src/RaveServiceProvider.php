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
        $this->bindAccountPayment();
        $this->bindAchPayment();
        $this->bindBill();
        $this->bindBvn();
        $this->bindCardPayment();
        $this->bindEbill();
        $this->bindRave();
        $this->bindVirtualAccount();
    }

    /**
    * Get the services provided by the provider
    *
    * @return array
    */
    public function provides()
    {
        return [
            'laravelaccountpayment',
            'laravelachpayment',
            'laravelbill',
            'laravelbvn',
            'laravelcardpayment',
            'laravelebill',
            'laravelrave',
            'laravelvirtualaccount',
        ];
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

    private function bindBill()
    {
        $this->app->singleton('laravelbill', function ($app) {
            return new Bill;
        });

        $this->app->alias('laravelbill', "Laravel\Flutterwave\Bill");
    }

    private function bindBvn()
    {
        $this->app->singleton('laravelbvn', function ($app) {
            return new Bvn;
        });

        $this->app->alias('laravelbvn', "Laravel\Flutterwave\Bvn");
    }

    private function bindCardPayment()
    {
        $this->app->singleton('laravelcardpayment', function ($app) {
            return new Card;
        });

        $this->app->alias('laravelcardpayment', "Laravel\Flutterwave\Card");
    }

    private function bindEbill()
    {
        $this->app->singleton('laravelebill', function ($app) {
            return new Ebill;
        });

        $this->app->alias('laravelebill', "Laravel\Flutterwave\Ebill");
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
}
