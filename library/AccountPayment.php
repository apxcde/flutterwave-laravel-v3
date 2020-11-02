<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveServiceTrait;

class Account
{
    use RaveServiceTrait;

    public function __construct()
    {
        parent::__construct();
        $this->type = array('debit_uk_account','debit_ng_account');
    }

    public function accountCharge($array)
    {
        //add tx_ref to the paylaod
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->rave->getTxRef();
        } else {
            $this->rave->setTxRef($array['tx_ref']);
        }

        if (!in_array($array['type'], $this->type)) {
            throw new \Exception("The Type specified in the payload  is not {$this->type[0]} or {$this->type[1]}", 1);
        }

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler());
        //set the endpoint for the api call
        if ($this->type === $this->type[0]) {
            $this->rave->setEndPoint("v3/charges?type=debit_uk_account");
        } else {
            $this->rave->setEndPoint("v3/charges?type=debit_ng_account");
        }


        return $this->rave->chargePayment($array);
    }
}
