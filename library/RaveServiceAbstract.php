<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\EventHandler;

abstract class RaveServiceAbstract
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

    // /**
    //  * Gets the txref ref of the rave instance
    //  * @return object
    //  * */
    // public function setRaveTxRef($tx_ref)
    // {
    //     if (!isset($tx_ref) || empty($tx_ref)) {
    //         $tx_ref = $this->payment->getTxRef();
    //     } else {
    //         $this->payment->getTxRef($tx_ref);
    //     }
    //
    //     return $thi;
    // }
}
