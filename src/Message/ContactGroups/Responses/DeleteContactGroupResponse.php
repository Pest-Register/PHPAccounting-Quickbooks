<?php

namespace PHPAccounting\Quickbooks\Message\ContactGroups\Responses;

use Omnipay\Common\Message\AbstractResponse;
use PHPAccounting\Quickbooks\Helpers\IndexSanityCheckHelper;

/**
 * Delete ContactGroup(s) Response
 * @package PHPAccounting\Quickbooks\Message\ContactGroups\Responses
 */
class DeleteContactGroupResponse extends AbstractResponse
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
     * Return all Contact Groups with Generic Schema Variable Assignment
     * @return array
     */
    public function getContactGroups(){
        $contactGroups = [];
        foreach ($this->data as $contactGroup) {
            $newContactGroup = [];
            $newContactGroup['accounting_id'] = IndexSanityCheckHelper::indexSanityCheck('ContactGroupID', $contactGroup);
            $newContactGroup['name'] = IndexSanityCheckHelper::indexSanityCheck('Name', $contactGroup);
            $newContactGroup['status'] = IndexSanityCheckHelper::indexSanityCheck('Status', $contactGroup);
            array_push($contactGroups, $newContactGroup);
        }

        return $contactGroups;
    }
}