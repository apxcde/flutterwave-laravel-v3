<?php
namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facade\Rave;
use Laravel\Flutterwave\EventHandlerInterface;

class subaccountEventHandler implements EventHandlerInterface
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

class Subaccount
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

        return new subaccountEventHandler;
    }

    public function createSubaccount($array)
    {
        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/subaccounts");
        //returns the value from the results`
        return Rave::createSubaccount($array);
    }

    public function getSubaccounts()
    {
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/subaccounts");
        //returns the value from the results
        return Rave::getSubaccounts();
    }

    public function fetchSubaccount($array)
    {
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/subaccounts/".$array['id']);
        //returns the value from the results
        return Rave::fetchSubaccount();
    }

    public function updateSubaccount($array)
    {
        if (!isset($array['id'])) {
            throw new \Exception("Missing id Parameter in the payload", 1);
        }

        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/subaccounts/".$array['id']);
        //returns the value from the results
        return Rave::updateSubaccount($array);
    }

    public function deleteSubaccount($array)
    {
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/subaccounts/".$array['id']);
        //returns the value from the results
        return Rave::deleteSubaccount();
    }
}