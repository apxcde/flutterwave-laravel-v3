<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveImplementAbstract;

class Transaction extends RaveImplementAbstract
{
    public function viewTransactions($array = array())
    {
        // create url query
        $url = url("v3/transactions");
        if (!empty($array)) {
            $query = http_build_query($array);
            $url .= "?{$query}";
        }

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint($url);
        //returns the value from the results
        return $this->rave->getAllTransactions();
    }

    public function getTransactionFee($array = array())
    {
        if (!isset($array['amount'])) {
            throw new \Exception("The following query param  is required amount", 1);
        }

        if (!isset($array['currency'])) {
            throw new \Exception("The following query param  is required currency", 1);
        }

        // create url query
        $query = http_build_query($array);

        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transactions/fee?{$query}");
        //returns the value from the results
        return $this->rave->getTransactionFee($array);
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

    public function verifyTransaction($id)
    {
        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transactions/".$id."/verify");
        //returns the value from the results
        return $this->rave->verifyTransaction($id);
    }

    public function validateTransaction($otp, $ref, $type)
    {
        //set the payment handler
        $this->rave->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/validate-charge");
        //returns the value from the results
        return $this->rave->validateTransaction($otp, $ref, $type);
    }
}
