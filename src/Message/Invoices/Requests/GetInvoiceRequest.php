<?php

namespace PHPAccounting\Quickbooks\Message\Invoices\Requests;
use PHPAccounting\Quickbooks\Message\AbstractRequest;
use PHPAccounting\Quickbooks\Message\Contacts\Responses\GetContactResponse;
use PHPAccounting\Quickbooks\Message\Invoices\Responses\GetInvoiceResponse;
use XeroPHP\Models\Accounting\Invoice;

/**
 * Get Invoice(s)
 * @package PHPAccounting\Quickbooks\Message\Invoices\Requests
 */
class GetInvoiceRequest extends AbstractRequest
{

    /**
     * Set AccountingID from Parameter Bag (InvoiceID generic interface)
     * @see https://developer.xero.com/documentation/api/invoices
     * @param $value
     * @return GetInvoiceRequest
     */
    public function setAccountingIDs($value) {
        return $this->setParameter('accounting_ids', $value);
    }

    /**
     * Set Page Value for Pagination from Parameter Bag
     * @see https://developer.xero.com/documentation/api/invoices
     * @param $value
     * @return GetInvoiceRequest
     */
    public function setPage($value) {
        return $this->setParameter('page', $value);
    }

    /**
     * Return Comma Delimited String of Accounting IDs (ContactGroupIDs)
     * @return mixed comma-delimited-string
     */
    public function getAccountingIDs() {
        if ($this->getParameter('accounting_ids')) {
            return implode(', ',$this->getParameter('accounting_ids'));
        }
        return null;
    }

    /**
     * Return Page Value for Pagination
     * @return integer
     */
    public function getPage() {
        if ($this->getParameter('page')) {
            return $this->getParameter('page');
        }

        return 1;
    }

    /**
     * Send Data to Xero Endpoint and Retrieve Response via Response Interface
     * @param mixed $data Parameter Bag Variables After Validation
     * @return \Omnipay\Common\Message\ResponseInterface|GetContactResponse
     */
    public function sendData($data)
    {
        try {
            $xero = $this->createXeroApplication();
            $xero->getOAuthClient()->setToken($this->getAccessToken());
            $xero->getOAuthClient()->setTokenSecret($this->getAccessTokenSecret());

            if ($this->getAccountingIDs()) {
                if(strpos($this->getAccountingIDs(), ',') === false) {
                    $invoices = $xero->loadByGUID(Invoice::class, $this->getAccountingIDs());
                }
                 else {
                     $invoices = $xero->loadByGUIDs(Invoice::class, $this->getAccountingIDs());
                 }
            } else {
                $invoices = $xero->load(Invoice::class)->page($this->getPage())->execute();
            }
            $response = $invoices;

        } catch (\Exception $exception) {
            $response = [
                'status' => 'error',
                'detail' => $exception->getMessage()
            ];
        }
        return $this->createResponse($response);
    }

    /**
     * Create Generic Response from Xero Endpoint
     * @param mixed $data Array Elements or Xero Collection from Response
     * @return GetInvoiceResponse
     */
    public function createResponse($data)
    {
        return $this->response = new GetInvoiceResponse($this, $data);
    }
}