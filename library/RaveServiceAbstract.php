<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\EventHandler;

abstract class RaveServiceAbstract
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

        return new EventHandler;
    }
}
