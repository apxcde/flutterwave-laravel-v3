<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\RaveServiceAbstract;

class Ebill implements RaveServiceAbstract
{
    protected $handler;

    public function __construct()
    {
        $this->keys = array('amount', 'phone_number','country', 'ip', 'email');
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

        return new ebillEventHandler;
    }

    public function order($array)
    {
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->payment->getTxRef();
        }

        if (!isset($array['amount']) || !isset($array['phone_number']) ||
        !isset($array['email']) || !isset($array['country']) || !isset($array['ip'])) {
            throw new \Exception("Missing values for one of the following body params: {$this->keys[0]}, {$this->keys[1]}, {$this->keys[2]}, {$this->keys[3]} and {$this->keys[4]}", 1);
        }


        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/ebills");
        //returns the value of the result.
        return Rave::createOrder($array);
    }

    public function updateOrder($data)
    {
        if (!isset($data['amount'])) {
            throw new \Exception("Missing values for one of the following body params: {$this->keys[0]} and reference", 1);
        }

        if (gettype($data['amount']) !== 'integer') {
            $data['amount'] = (int) $data['amount'];
        }

        Rave::eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/ebills/".$data['reference']);
        //returns the value of the result.
        return Rave::updateOrder($data);
    }
}
