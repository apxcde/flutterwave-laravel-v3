<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facade\Rave;

class Misc
{
    public function getBalances()
    {
        Rave::setEndPoint("v3/balances");
        return Rave::getTransferBalance($array);
    }

    public function getBalance($array)
    {
        if (!isset($array['currency'])) {
            $array['currency'] = 'NGN';
        }

        Rave::setEndPoint("v3/balances/".$array['currency']);
        return Rave::getTransferBalance($array);
    }

    public function verifyAccount($array)
    {
        Rave::setEndPoint("v3/accounts/resolve");
        return Rave::verifyAccount($array);
    }
}
