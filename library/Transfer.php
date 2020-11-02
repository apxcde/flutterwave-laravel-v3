<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\RaveServiceTrait;

class Transfer
{
    use RaveServiceTrait;

    /**
     * initiating a single transfer
     * @return object
     * */
    public function singleTransfer($array)
    {
        //set the payment handler
        $this->transfer->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transfers");
        //returns the value from the results
        return $this->transfer->transferSingle($array);
    }

    /**
     * initiating a bulk transfer
     * @return object
     * */
    public function bulkTransfer($array)
    {
        //set the payment handler
        $this->transfer->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/bulk-transfers");
        //returns the value from the results
        return $this->transfer->transferBulk($array);
    }

    public function listTransfers($array = array('url'=>'blank'))
    {
        //set the payment handler
        $this->transfer->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/transfers");

        return $this->transfer->listTransfers($array);
    }

    public function bulkTransferStatus($array)
    {
        //set the payment handler
        $this->transfer->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/bulk-transfers");

        return $this->transfer->bulkTransferStatus($array);
    }

    public function getTransferFee($array)
    {
        if (in_array('amount', $array) && gettype($array['amount']) !== "string") {
            $array['amount'] = (string) $array['amount'];
        }

        //set the payment handler
        $this->transfer->eventHandler($this->getEventHandler())
         //set the endpoint for the api call
         ->setEndPoint("v3/transfers/fee");

        return $this->transfer->applicableFees($array);
    }

    public function getBanksForTransfer($data)
    {
        if (!isset($array['country'])) {
            throw new \Exception("Missing value for country in your payload", 1);
        }

        //set the payment handler
        $his->transfer->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v2/banks/".$data['country']."/");

        return $this->transfer->getBanksForTransfer();
    }

    public function verifyTransaction()
    {
        //verify the charge
        return $this->transfer->verifyTransaction($this->transfer->txref);
    }
}
