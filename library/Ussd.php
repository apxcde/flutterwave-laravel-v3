<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveServiceTrait;

class Ussd
{
    use RaveServiceTrait;

    public function ussd($array)
    {
        $this->rave->setType('ussd');

        //add tx_ref to the paylaod
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->rave->getTxRef();
        }

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/charges?type=".$this->rave->getType());
        //returns the value from the results
        return $this->rave->chargePayment($array);
    }
}
