<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Rave;
use Laravel\Flutterwave\EventHandlerInterface;

class paymentPlanEventHandler implements EventHandlerInterface
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


class PaymentPlan
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

        return new paymentPlanEventHandler;
    }

    public function createPlan($array)
    {
        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/payment-plans");

        if (empty($array['amount']) || !array_key_exists('amount', $array) ||
        empty($array['name']) || !array_key_exists('name', $array) ||
        empty($array['interval']) || !array_key_exists('interval', $array) ||
        empty($array['duration']) || !array_key_exists('duration', $array)) {
            throw new \Exception("Missing values for the following parameters amount, name , interval, or duration", 1);
        }

        //returns the value from the results
        return Rave::createPlan($array);
    }

    public function updatePlan($array)
    {
        if (!isset($array['id']) || !isset($array['name']) || !isset($array['status'])) {
            throw new \Exception("Missing values for a parametter: id, name, or status", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/payment-plans/".$array['id']);


        return Rave::updatePlan($array);
    }

    public function cancelPlan($array)
    {
        if (!isset($array['id'])) {
            throw new \Exception("Missing values for a parametter: id", 1);
        }

        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/payment-plans/".$array['id']."/cancel");

        return Rave::cancelPlan($array);
    }

    public function getPlans()
    {
        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/payment-plans");

        return Rave::getPlans();
    }

    public function get_a_Plan($array)
    {
        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/payment-plans/".$array['id']);

        return Rave::get_a_Plan();
    }
}