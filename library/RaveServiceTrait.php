<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\EventHandler;

trait RaveServiceTrait
{
    protected $rave;
    protected $handler;

    public function __construct()
    {
        $this->rave = Rave::getRaveInstance();
    }

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

        return new EventHandler;
    }

    /**
     * Gets the txref ref of the rave instance
     * @return object
     * */
    public function getRaveInstance()
    {
        return $this->rave;
    }

    /**you will need to verify the charge
     * After validation then verify the charge with the txRef
     * You can write out your function to execute when the verification is successful in the onSuccessful function
    ***/
    public function verifyTransaction()
    {
        //verify the charge
        return $this->rave->verifyTransaction($this->rave->getTxRef());
    }
}
