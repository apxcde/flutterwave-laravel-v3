<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveImplementAbstract;

class Card extends RaveImplementAbstract
{
    public function cardCharge($array)
    {
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->rave->getTxRef();
        } else {
            $this->rave->getTxRef($array['tx_ref']);
        }

        $this->rave->setType('card');
        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/charges?type=".$this->rave->getType());

        //returns the value from the results
        return $this->rave->chargePayment($array);
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
        return $this->rave->validateTransaction($element, $ref, $this->rave->getType());
    }
}
