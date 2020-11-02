<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveServiceTrait;

class Transactions
{
    use RaveServiceTrait;

    public function viewTransactions()
    {
        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transactions");
        //returns the value from the results
        return $this->rave->getAllTransactions();
    }

    public function getTransactionFee($array = array())
    {
        if (!isset($array['amount'])) {
            throw new \Exception("The following query param  is required amount", 1);
        }

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transactions/fee");
        //returns the value from the results
        return $this->rave->getTransactionFee($array);
    }

    public function verifyTransaction($id)
    {
        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transactions/".$id."/verify");
        //returns the value from the results
        return $this->rave->verifyTransaction($id);
    }


    public function viewTimeline($array = array())
    {
        if (!isset($array['id'])) {
            throw new \Exception("Missing value for id in your payload", 1);
        }

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transactions/".$array['id']."/events");
        //returns the value from the results
        return $this->rave->transactionTimeline();
    }
}
