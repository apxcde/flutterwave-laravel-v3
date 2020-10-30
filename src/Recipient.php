<?php
namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facade\Rave;
use Laravel\Flutterwave\EventHandlerInterface;

class recipientEventHandler implements EventHandlerInterface{
    /**
     * This is called when the Rave class is initialized
     * */
    function onInit($initializationData) {
        // Save the transaction to your DB.
    }

    /**
     * This is called only when a transaction is successful
     * */
    function onSuccessful($transactionData){
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
    function onFailure($transactionData){
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here

    }

    /**
     * This is called when a transaction is requeryed from the payment gateway
     * */
    function onRequery($transactionReference){
        // Do something, anything!
    }

    /**
     * This is called a transaction requery returns with an error
     * */
    function onRequeryError($requeryResponse){
        // Do something, anything!
    }

    /**
     * This is called when a transaction is canceled by the user
     * */
    function onCancel($transactionReference){
        // Do something, anything!
        // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution

    }

    /**
     * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
     * */
    function onTimeout($transactionReference, $data){
        // Get the transaction from your DB using the transaction reference (txref)
        // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
        // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects

    }
}


class Recipient {
    protected $handler;

    /**
     * Sets the event hooks for all available triggers
     * @param object $handler This is a class that implements the Event Handler Interface
     * @return object
     * */
    function eventHandler($handler){
        $this->handler = $handler;
        return $this;
    }

    /**
     * Gets the event hooks for all available triggers
     * @return object
     * */
    function getEventHandler(){
        if ($this->handler) {
            return $this->handler;
        }

        return new recipientEventHandler;
    }

    function createRecipient($array){
        //set the payment handler

        if(!isset($array['account_number']) || !isset($array['account_bank'])){
            throw new \Exception("The following body params are required account_number and account_bank", 1);
        }

        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/beneficiaries");
        //returns the value from the results
        return Rave::createBeneficiary($array);
    }

    function listRecipients(){
        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/beneficiaries");
        //returns the value from the results
        return Rave::getBeneficiaries();
    }

    function fetchBeneficiary($array){
        if(!isset($array['id'])){
            throw new \Exception("The following PATH param is required : id", 1);
        }

        if(gettype($array['id']) !== 'string'){
            $array['id'] = (string) $array['id'];
        }

        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/beneficiaries/". $array['id']);
        //returns the value from the results
        return Rave::getBeneficiaries();
    }

    function deleteBeneficiary($array){

        if(!isset($array['id'])){
            throw new \Exception("The following PATH param is required : id", 1);
        }

        if(gettype($array['id']) !== 'string'){
            $array['id'] = (string) $array['id'];
        }

        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/beneficiaries/". $array['id']);
        //returns the value from the results
        return Rave::deleteBeneficiary();
    }

}
