<?php

namespace Laravel\Flutterwave;

use Laravel\Flutterwave\Facades\Rave;
use Laravel\Flutterwave\RaveServiceAbstract;

class Bill implements RaveServiceAbstract
{
    protected $payment;

    public function __construct()
    {
        $this->payment = Rave::getRaveInstance();
        $this->type = array('AIRTIME','DSTV','DSTV BOX OFFICE', 'Postpaid', 'Prepaid', 'AIRTEL', 'IKEDC TOP UP','EKEDC POSTPAID TOPUP', 'EKEDC PREPAID TOPUP', 'LCC', 'KADUNA TOP UP');
    }

    public function payBill($array)
    {
        if (gettype($array['amount']) !== 'integer') {
            throw new \Exception("Specified amount should be an integer and not a string", 1);
        }

        if (!in_array($array['type'], $this->type, true)) {
            throw new \Exception("The Type specified in the payload  is not {$this->type[0]}, {$this->type[1]}, {$this->type[2]} or {$this->type[3]}", 1);
        }

        switch ($array['type']) {
            case 'DSTV':
                //set type to dstv
                $this->type = 'DSTV';
                break;

            case 'EKEDC POSTPAID TOPUP':
                //set type to ekedc
                $this->type = 'EKEDC POSTPAID TOPUP';
                break;

            case 'LCC':
                //set type to lcc
                $this->type = 'LCC';
                break;

            case 'AIRTEL':
                //set type to airtel
                $this->type = 'AIRTEL';
                break;

            case 'Postpaid':
                //set type to postpaid
                $this->type = 'Postpaid';
                break;

            case 'IKEDC TOP UP':
                //set type to ikedc
                $this->type = 'IKEDC TOP UP';
                break;

            case 'KADUNA TOP UP':
                //set type to kaduna top up
                $this->type = 'KADUNA TOP UP';
                break;

            case 'DSTV BOX OFFICE':
                //set type to dstv box office
                $this->type = 'DSTV BOX OFFICE';
                break;

            default:
                //set type to airtime
                $this->type = 'AIRTIME';
                break;
        }

        $this->payment->eventHandler($this->getEventHandler())
        //set the endpoint for the api call
        ->setEndPoint("v3/bills");

        return $this->payment->bill($array);
    }

    public function bulkBill($array)
    {
        if (!array_key_exists('bulk_reference', $array) || !array_key_exists('callback_url', $array) || !array_key_exists('bulk_data', $array)) {
            throw new \Exception("Please Enter the required body parameters for the request", 1);
        }

        $this->payment->eventHandler($this->getEventHandler())

        ->setEndPoint('v3/bulk-bills');

        return $this->payment->bulkBills($array);
    }

    public function getBill($array)
    {
        $this->payment->eventHandler($this->getEventHandler());

        if (array_key_exists('reference', $array) && !array_key_exists('from', $array)) {
            $this->payment->setEndPoint('v3/bills/'.$array['reference']);
        } elseif (array_key_exists('code', $array) && !array_key_exists('customer', $array)) {
            $this->payment->setEndPoint('v3/bill-items');
        } elseif (array_key_exists('id', $array) && array_key_exists('product_id', $array)) {
            $this->payment->setEndPoint('v3/billers');
        } elseif (array_key_exists('from', $array) && array_key_exists('to', $array)) {
            if (isset($array['page']) && isset($array['reference'])) {
                $this->payment->setEndPoint('v3/bills');
            } else {
                $this->payment->setEndPoint('v3/bills');
            }
        }

        return $this->payment->getBill($array);
    }

    public function getBillCategories()
    {
        $this->payment->eventHandler($this->getEventHandler())

        ->setEndPoint('v3');

        return $this->payment->getBillCategories();
    }

    public function getAgencies()
    {
        $this->payment->eventHandler($this->getEventHandler())

        ->setEndPoint('v3');

        return $this->payment->getBillers();
    }
}
