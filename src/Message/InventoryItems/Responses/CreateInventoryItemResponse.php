<?php

namespace PHPAccounting\Quickbooks\Message\InventoryItems\Responses;

use Omnipay\Common\Message\AbstractResponse;
use QuickBooksOnline\API\Data\IPPItem;

/**
 * Create Inventory Item(s) Response
 * @package PHPAccounting\XERO\Message\InventoryItems\Responses
 */
class CreateInventoryItemResponse extends AbstractResponse
{
    /**
     * Check Response for Error or Success
     * @return boolean
     */
    public function isSuccessful()
    {
        if(!is_array($this->data)){
            return false;
        }
        return true;
    }

    /**
     * Fetch Error Message from Response
     * @return string
     */
    public function getErrorMessage(){
        if($this->data->status){
            return $this->data;
        }
        return null;
    }

    /**
     * Return all Payments with Generic Schema Variable Assignment
     * @return array
     */
    public function getInventoryItems(){
        $items = [];
        var_dump($this->data);
        if ($this->data instanceof IPPItem){
            $item = $this->data;
            $newItem = [];
            $newItem['accounting_id'] = $item->Id;
            $newItem['name'] = $item->Name;
            $newItem['description'] = $item->Description;
            $newItem['type'] = $item->Type;
            $newItem['is_buying'] = ($item->IncomeAccountRef ? true : false);
            $newItem['is_selling'] = ($item->ExpenseAccountRef ? true : false);
            $newItem['is_tracked'] = $item->TrackQtyOnHand;
            $newItem['buying_description'] = $item->PurchaseDesc;
            $newItem['selling_description'] = $item->Description;
            $newItem['quantity'] = $item->QtyOnHand;
            $newItem['cost_pool'] = $item->AvgCost;
            $newItem['updated_at'] = $item->MetaData->LastUpdatedTime;
            if ($item->TrackQtyOnHand) {
                $item['buying_account_code'] = $item->COGSAccountRef;
            } else {
                $item['buying_account_code'] = $item->ExpenseAccountRef;
            }
            $item['buying_tax_type_code'] = $item->PurchaseTaxCodeRef;
            $item['buying_unit_price'] = $item->PurchaseCost;
            $item['selling_account_code'] = $item->IncomeAccountRef;
            $item['selling_tax_type_code'] = $item->SalesTaxCodeRef;
            $item['selling_unit_price'] = $item->UnitPrice;
            array_push($items, $newItem);

        } else {
            foreach ($this->data as $item) {
                $newItem = [];
                $newItem['accounting_id'] = $item->Id;
                $newItem['name'] = $item->Name;
                $newItem['description'] = $item->Description;
                $newItem['type'] = $item->Type;
                $newItem['is_buying'] = ($item->IncomeAccountRef ? true : false);
                $newItem['is_selling'] = ($item->ExpenseAccountRef ? true : false);
                $newItem['is_tracked'] = $item->TrackQtyOnHand;
                $newItem['buying_description'] = $item->PurchaseDesc;
                $newItem['selling_description'] = $item->Description;
                $newItem['quantity'] = $item->QtyOnHand;
                $newItem['cost_pool'] = $item->AvgCost;
                $newItem['updated_at'] = $item->MetaData->LastUpdatedTime;
                if ($item->TrackQtyOnHand) {
                    $newItem['buying_account_code'] = $item->COGSAccountRef;
                } else {
                    $newItem['buying_account_code'] = $item->ExpenseAccountRef;
                }
                $newItem['buying_tax_type_code'] = $item->PurchaseTaxCodeRef;
                $newItem['buying_unit_price'] = $item->PurchaseCost;
                $newItem['selling_account_code'] = $item->IncomeAccountRef;
                $newItem['selling_tax_type_code'] = $item->SalesTaxCodeRef;
                $newItem['selling_unit_price'] = $item->UnitPrice;
                array_push($items, $newItem);
            }
        }

        return $items;
    }
}