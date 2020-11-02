<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveServiceTrait;

class TransactionVerification
{
    use RaveServiceTrait;

    public function transactionVerify($id)
    {
        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler());
        //returns the value from the results
        return $this->rave->verifyTransaction($id);
    }
}
