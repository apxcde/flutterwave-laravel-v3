<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\RaveServiceAbstract;

class Ach implements RaveServiceAbstract
{
    protected $payment;

    public function __construct()
    {
        $this->payment = Rave::getRaveInstance();
    }

    public function achCharge($array)
    {
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->payment->getTxRef();
        } else {
            $this->payment->setTxRef($array['tx_ref']);
        }

        $this->payment->setType('ach_payment');
        //set the payment handler
        $this->payment->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/charges?type=".$this->payment->getType());

        //returns the value from the results
        return $this->payment->chargePayment($array);
    }


    public function verifyTransaction($id)
    {
        //verify the charge
        return $this->payment->verifyTransaction($id);
    }
}
