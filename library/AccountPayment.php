<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\RaveServiceAbstract;

class Account implements RaveServiceAbstract
{
    protected $payment;

    public function __construct()
    {
        $this->payment = Rave::getRaveInstance();
        $this->type = array('debit_uk_account','debit_ng_account');
        $this->valType = "account";
    }

    public function accountCharge($array)
    {
        //add tx_ref to the paylaod
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->payment->getTxRef();
        } else {
            $this->payment->setTxRef($array['tx_ref']);
        }

        if (!in_array($array['type'], $this->type)) {
            throw new \Exception("The Type specified in the payload  is not {$this->type[0]} or {$this->type[1]}", 1);
        }

        //set the payment handler
        $this->payment->eventHandler($this->getEventHandler());
        //set the endpoint for the api call
        if ($this->type === $this->type[0]) {
            $this->payment->setEndPoint("v3/charges?type=debit_uk_account");
        } else {
            $this->payment->setEndPoint("v3/charges?type=debit_ng_account");
        }


        return $this->payment->chargePayment($array);
    }

    public function validateTransaction($otp, $ref)
    {
        //validate the charge
        $this->payment->eventHandler($this->getEventHandler());

        return $this->payment->validateTransaction($otp, $ref, $this->payment->getType());
    }

    public function verifyTransaction($id)
    {
        //verify the charge
        return $this->payment->verifyTransaction($id);
    }
}
