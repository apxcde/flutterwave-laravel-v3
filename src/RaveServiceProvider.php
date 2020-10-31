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
        $this->bindMisc();
        $this->bindMobileMoney();
        $this->bindMpesa();
        $this->bindPaymentPlan();
        $this->bindRave();
        $this->bindRecipient();
        $this->bindSettlement();
        $this->bindSubaccount();
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
            'flutterwaveaccountpayment',
            'flutterwaveachpayment',
            'flutterwavebill',
            'flutterwavebvn',
            'flutterwavecardpayment',
            'flutterwaveebill',
            'flutterwavemisc',
            'flutterwavemobilemoney',
            'flutterwavempesa',
            'flutterwavepaymentplan',
            'flutterwaverave',
            'flutterwaverecipient,'
            'flutterwavesetlement',
            'flutterwavesubaccount',
            'flutterwavevirtualaccount',
        ];
    }

    private function bindAccountPayment()
    {
        $this->app->singleton('flutterwaveaccountpayment', function ($app) {
            return new Account;
        });

        $this->app->alias('flutterwaveaccountpayment', "Laravel\Flutterwave\Account");
    }

    private function bindAchPayment()
    {
        $this->app->singleton('flutterwaveachpayment', function ($app) {
            return new Ach;
        });

        $this->app->alias('flutterwaveachpayment', "Laravel\Flutterwave\Ach");
    }

    private function bindBill()
    {
        $this->app->singleton('flutterwavebill', function ($app) {
            return new Bill;
        });

        $this->app->alias('flutterwavebill', "Laravel\Flutterwave\Bill");
    }

    private function bindBvn()
    {
        $this->app->singleton('flutterwavebvn', function ($app) {
            return new Bvn;
        });

        $this->app->alias('flutterwavebvn', "Laravel\Flutterwave\Bvn");
    }

    private function bindCardPayment()
    {
        $this->app->singleton('flutterwavecardpayment', function ($app) {
            return new Card;
        });

        $this->app->alias('flutterwavecardpayment', "Laravel\Flutterwave\Card");
    }

    private function bindEbill()
    {
        $this->app->singleton('flutterwaveebill', function ($app) {
            return new Ebill;
        });

        $this->app->alias('flutterwaveebill', "Laravel\Flutterwave\Ebill");
    }

    private function bindMisc()
    {
        $this->app->singleton('flutterwavemisc', function ($app) {
            return new Misc;
        });

        $this->app->alias('flutterwavemisc', "Laravel\Flutterwave\Misc");
    }

    private function bindMobileMoney()
    {
        $this->app->singleton('flutterwavemobilemoney', function ($app) {
            return new MobileMoney;
        });

        $this->app->alias('flutterwavemobilemoney', "Laravel\Flutterwave\MobileMoney");
    }

    private function bindMpesa()
    {
        $this->app->singleton('flutterwavempesa', function ($app) {
            return new Mpesa;
        });

        $this->app->alias('flutterwavempesa', "Laravel\Flutterwave\Mpesa");
    }

    private function bindPaymentPlan()
    {
        $this->app->singleton('flutterwavepaymentplan', function ($app) {
            return new PaymentPlan;
        });

        $this->app->alias('flutterwavepaymentplan', "Laravel\Flutterwave\PaymentPlan");
    }

    private function bindRave()
    {
        $this->app->singleton('flutterwaverave', function ($app) {
            $secret_key = config('flutterwave.secret_key');
            $prefix = config('app.name');

            return new Rave($secret_key, $prefix);
        });

        $this->app->alias('flutterwaverave', "Laravel\Flutterwave\Rave");
    }

    private function bindRecipient()
    {
        $this->app->singleton('flutterwaverecipient', function ($app) {
            return new Recipient;
        });

        $this->app->alias('flutterwaverecipient', "Laravel\Flutterwave\Recipient");
    }

    private function bindSettlement()
    {
        $this->app->singleton('flutterwavesetlement', function ($app) {
            return new Settlement;
        });

        $this->app->alias('flutterwavesetlement', "Laravel\Flutterwave\Settlement");
    }

    private function bindSubaccount()
    {
        $this->app->singleton('flutterwavesubaccount', function ($app) {
            return new Subaccount;
        });

        $this->app->alias('flutterwavesubaccount', "Laravel\Flutterwave\Subaccount");
    }

    private function bindVirtualAccount()
    {
        $this->app->singleton('flutterwavevirtualaccount', function ($app) {
            return new VirtualAccount;
        });

        $this->app->alias('flutterwavevirtualaccount', "Laravel\Flutterwave\VirtualAccount");
    }
}
