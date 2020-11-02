<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\RaveServiceAbstract;

class Card implements RaveServiceAbstract
{
    protected $payment;

    public function __construct()
    {
        $this->payment = Rave::getRaveInstance();
        $this->valType = "card";
    }

    public function cardCharge($array)
    {
        // set the payment tx_ref
        $this->setRaveTxRef($array['tx_ref'] ?? null);

        $this->payment->setType('card');
        //set the payment handler
        $this->payment->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/charges?type=".$this->payment->getType());

        //returns the value from the results
        return $this->payment->chargePayment($array);
    }

    /**
     * you will need to validate and verify the charge
     * Validating the charge will require an otp
     * After validation then verify the charge with the txRef
     * You can write out your function to execute when the verification is successful in the onSuccessful function
    ***/
    public function validateTransaction($element, $ref)
    {
        //validate the charge
        return $this->payment->validateTransaction($element, $ref, $this->payment->getType());
    }

    public function verifyTransaction($id)
    {
        //verify the charge
        return $this->payment->verifyTransaction($id);
    }
}
