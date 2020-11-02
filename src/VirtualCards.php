<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\EventHandlerInterface;

class virtualCardEventHandler implements EventHandlerInterface
{
    /**
     * This is called when the Rave class is initialized
     * */
    public function onInit($initializationData)
    {
        // Save the transaction to your DB.
    }

    /**
     * This is called only when a transaction is successful
     * */
    public function onSuccessful($transactionData)
    {
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Comfirm that the transaction is successful
        // Confirm that the chargecode is 00 or 0
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here
    }

    /**
     * This is called only when a transaction failed
     * */
    public function onFailure($transactionData)
    {
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here
    }

    /**
     * This is called when a transaction is requeryed from the payment gateway
     * */
    public function onRequery($transactionReference)
    {
        // Do something, anything!
    }

    /**
     * This is called a transaction requery returns with an error
     * */
    public function onRequeryError($requeryResponse)
    {
        // Do something, anything!
    }

    /**
     * This is called when a transaction is canceled by the user
     * */
    public function onCancel($transactionReference)
    {
        // Do something, anything!
        // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution
    }

    /**
     * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
     * */
    public function onTimeout($transactionReference, $data)
    {
        // Get the transaction from your DB using the transaction reference (txref)
        // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
        // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects
    }
}

class VirtualCard
{
    protected $handler;

    /**
     * Sets the event hooks for all available triggers
     * @param object $handler This is a class that implements the Event Handler Interface
     * @return object
     * */
    public function eventHandler($handler)
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * Gets the event hooks for all available triggers
     * @return object
     * */
    public function getEventHandler()
    {
        if ($this->handler) {
            return $this->handler;
        }

        return new virtualCardEventHandler;
    }

    //create card function
    public function createCard($array)
    {
        //set the endpoint for the api call
        if (!isset($array['currency']) || !isset($array['amount']) || !isset($array['billing_name'])) {
            throw new \Exception("Please pass the required values for currency, duration and amount", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards");

        return Rave::vcPostRequest($array);
    }

    //get the detials of a card using the card id
    public function getCard($array)
    {
        if (!isset($array['id'])) {
            throw new \Exception("Please pass the required value for id", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/".$array['id']);

        return Rave::vcGetRequest();
    }

    //list all the virtual cards on your profile
    public function listCards()
    {

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/");

        return Rave::vcGetRequest();
    }

    //terminate a virtual card on your profile
    public function terminateCard($array)
    {
        if (!isset($array['id'])) {
            throw new \Exception("Please pass the required value for id", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/".$array['id']."/terminate");

        return Rave::vcPutRequest();
    }

    //fund a virtual card
    public function fundCard($array)
    {
        //set the endpoint for the api call
        if (gettype($array['amount']) !== 'integer') {
            $array['amount'] = (int) $array['amount'];
        }

        if (!isset($array['currency'])) {
            $array['currency'] = 'NGN';
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/".$array['id']."/fund");

        $data = array(
            "amount"=> $array['amount'],
            "debit_currency"=> $array['currency']
        );

        return Rave::vcPostRequest($data);
    }

    // list card transactions
    public function cardTransactions($array)
    {

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/".$array['id']."/transactions");

        return Rave::vcGetRequest($array);
    }

    //withdraw funds from card
    public function cardWithdrawal($array)
    {
        //set the endpoint for the api call
        if (!isset($array['amount'])) {
            throw new \Exception("Please pass the required value for amount", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/".$array['id']."/withdraw");

        return  Rave::vcPostRequest($array);
    }

    public function block_unblock_card($array)
    {
        if (!isset($array['id']) || !isset($array['status_action'])) {
            throw new \Exception("Please pass the required value for id and status_action", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/virtual-cards/".$array['id']."/"."status/".$array['status_action']);

        return Rave::vcPutRequest();
    }
}
