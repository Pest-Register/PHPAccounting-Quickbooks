<?php

namespace PHPAccounting\Quickbooks\Message\InventoryItems\Responses;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Update Inventory Item(s) Response
 * @package PHPAccounting\Quickbooks\Message\InventoryItems\Responses
 */
class UpdateInventoryItemResponse extends AbstractResponse
{

    /**
     * Check Response for Error or Success
     * @return boolean
     */
    public function isSuccessful()
    {
        if(array_key_exists('status', $this->data)){
            return !$this->data['status'] == 'error';
        }
        return true;
    }

    /**
     * Fetch Error Message from Response
     * @return string
     */
    public function getErrorMessage(){
        if(array_key_exists('status', $this->data)){
            return $this->data['detail'];
        }
        return null;
    }

    /**
     * Return all Payments with Generic Schema Variable Assignment
     * @return array
     */
    public function getInventoryItems(){
        $items = [];

        return $items;
    }
}