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
        $this->bindSubscription();
        $this->bindTokinizedCharge();
        $this->bindTransactions();
        $this->bindTransactionVerification();
        $this->bindTransfer();
        $this->bindUssd();
        $this->bindVirtualAccount();
        $this->bindVirtualCard();
        $this->bindVoucherPayment();
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
            'flutterwaverecipient',
            'flutterwavesetlement',
            'flutterwavesubaccount',
            'flutterwavesubscription',
            'flutterwavetokenizedcharge',
            'flutterwavetransactions',
            'flutterwavetransactionverification',
            'flutterwavetransfer',
            'flutterussd',
            'flutterwavevirtualaccount',
            'flutterwavevirtualCard',
            'fluttervoucherpayment',
        ];
    }

    private function bindAccountPayment()
    {
        $this->app->bind('flutterwaveaccountpayment', function ($app) {
            return new Account;
        });

        $this->app->alias('flutterwaveaccountpayment', "Laravel\Flutterwave\Account");
    }

    private function bindAchPayment()
    {
        $this->app->bind('flutterwaveachpayment', function ($app) {
            return new Ach;
        });

        $this->app->alias('flutterwaveachpayment', "Laravel\Flutterwave\Ach");
    }

    private function bindBill()
    {
        $this->app->bind('flutterwavebill', function ($app) {
            return new Bill;
        });

        $this->app->alias('flutterwavebill', "Laravel\Flutterwave\Bill");
    }

    private function bindBvn()
    {
        $this->app->bind('flutterwavebvn', function ($app) {
            return new Bvn;
        });

        $this->app->alias('flutterwavebvn', "Laravel\Flutterwave\Bvn");
    }

    private function bindCardPayment()
    {
        $this->app->bind('flutterwavecardpayment', function ($app) {
            return new Card;
        });

        $this->app->alias('flutterwavecardpayment', "Laravel\Flutterwave\Card");
    }

    private function bindEbill()
    {
        $this->app->bind('flutterwaveebill', function ($app) {
            return new Ebill;
        });

        $this->app->alias('flutterwaveebill', "Laravel\Flutterwave\Ebill");
    }

    private function bindMisc()
    {
        $this->app->bind('flutterwavemisc', function ($app) {
            return new Misc;
        });

        $this->app->alias('flutterwavemisc', "Laravel\Flutterwave\Misc");
    }

    private function bindMobileMoney()
    {
        $this->app->bind('flutterwavemobilemoney', function ($app) {
            return new MobileMoney;
        });

        $this->app->alias('flutterwavemobilemoney', "Laravel\Flutterwave\MobileMoney");
    }

    private function bindMpesa()
    {
        $this->app->bind('flutterwavempesa', function ($app) {
            return new Mpesa;
        });

        $this->app->alias('flutterwavempesa', "Laravel\Flutterwave\Mpesa");
    }

    private function bindPaymentPlan()
    {
        $this->app->bind('flutterwavepaymentplan', function ($app) {
            return new PaymentPlan;
        });

        $this->app->alias('flutterwavepaymentplan', "Laravel\Flutterwave\PaymentPlan");
    }

    private function bindRave()
    {
        $this->app->bind('flutterwaverave', function ($app) {
            $secret_key = config('flutterwave.secret_key');
            $prefix = config('app.name');

            return new Rave($secret_key, $prefix);
        });

        $this->app->alias('flutterwaverave', "Laravel\Flutterwave\Rave");
    }

    private function bindRecipient()
    {
        $this->app->bind('flutterwaverecipient', function ($app) {
            return new Recipient;
        });

        $this->app->alias('flutterwaverecipient', "Laravel\Flutterwave\Recipient");
    }

    private function bindSettlement()
    {
        $this->app->bind('flutterwavesetlement', function ($app) {
            return new Settlement;
        });

        $this->app->alias('flutterwavesetlement', "Laravel\Flutterwave\Settlement");
    }

    private function bindSubaccount()
    {
        $this->app->bind('flutterwavesubaccount', function ($app) {
            return new Subaccount;
        });

        $this->app->alias('flutterwavesubaccount', "Laravel\Flutterwave\Subaccount");
    }

    private function bindSubscription()
    {
        $this->app->bind('flutterwavesubscription', function ($app) {
            return new Subscription;
        });

        $this->app->alias('flutterwavesubscription', "Laravel\Flutterwave\Subscription");
    }

    private function bindTokinizedCharge()
    {
        $this->app->bind('flutterwavetokenizedcharge', function ($app) {
            return new TokinizedCharge;
        });

        $this->app->alias('flutterwavetokenizedcharge', "Laravel\Flutterwave\TokinizedCharge");
    }

    private function bindTransactions()
    {
        $this->app->bind('flutterwavetransactions', function ($app) {
            return new Transactions;
        });

        $this->app->alias('flutterwavetransactions', "Laravel\Flutterwave\Transactions");
    }

    private function bindTransactionVerification()
    {
        $this->app->bind('flutterwavetransactionverification', function ($app) {
            return new TransactionVerification;
        });

        $this->app->alias('flutterwavetransactionverification', "Laravel\Flutterwave\TransactionVerification");
    }

    private function bindTransfer()
    {
        $this->app->bind('flutterwavetransfer', function ($app) {
            return new Transfer;
        });

        $this->app->alias('flutterwavetransfer', "Laravel\Flutterwave\Transfer");
    }

    private function bindUssd()
    {
        $this->app->bind('flutterussd', function ($app) {
            return new Ussd;
        });

        $this->app->alias('flutterussd', "Laravel\Flutterwave\Ussd");
    }

    private function bindVirtualAccount()
    {
        $this->app->bind('flutterwavevirtualaccount', function ($app) {
            return new VirtualAccount;
        });

        $this->app->alias('flutterwavevirtualaccount', "Laravel\Flutterwave\VirtualAccount");
    }

    private function bindVirtualCard()
    {
        $this->app->bind('fluttervirtualcard', function ($app) {
            return new VirtualCard;
        });

        $this->app->alias('fluttervirtualcard', "Laravel\Flutterwave\VirtualCard");
    }

    private function bindVoucherPayment()
    {
        $this->app->bind('fluttervoucherpayment', function ($app) {
            return new VoucherPayment;
        });

        $this->app->alias('fluttervoucherpayment', "Laravel\Flutterwave\VoucherPayment");
    }
}
