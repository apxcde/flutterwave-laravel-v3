<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveServiceTrait;

class Ach
{
    use RaveServiceTrait;

    public function achCharge($array)
    {
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->rave->getTxRef();
        } else {
            $this->rave->setTxRef($array['tx_ref']);
        }

        $this->rave->setType('ach_payment');

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/charges?type=".$this->rave->getType());

        //returns the value from the results
        return $this->rave->chargePayment($array);
    }
}
