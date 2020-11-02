<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\RaveServiceAbstract;

class Bvn implements RaveServiceAbstract
{
    protected $bvn;

    public function __construct()
    {
        $this->bvn = Rave::getRaveInstance();
    }

    public function verifyBVN($bvn)
    {
        //set the payment handler
        Rave::eventHandler($this->getEventHandler())
        ->setEndPoint("v3/kyc/bvns");
        //returns the value from the results
        return Rave::bvn($bvn);
    }
}
