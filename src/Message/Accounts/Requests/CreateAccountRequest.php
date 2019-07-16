<?php

namespace PHPAccounting\Quickbooks\Message\Accounts\Requests;

use PHPAccounting\Quickbooks\Message\AbstractRequest;
use PHPAccounting\Quickbooks\Message\Accounts\Responses\CreateAccountResponse;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Account;


/**
 * Create Account(s)
 * @package PHPAccounting\XERO\Message\Accounts\Requests
 */
class CreateAccountRequest extends AbstractRequest
{
    /**
     * Get Code Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @return mixed
     */
    public function getCode(){
        return $this->getParameter('code');
    }

    /**
     * Set Code Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @param string $value Account Code
     * @return CreateAccountRequest
     */
    public function setCode($value){
        return $this->setParameter('code', $value);
    }

    /**
     * Get Name Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @return mixed
     */
    public function getName(){
        return $this->getParameter('name');
    }

    /**
     * Set Name Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @param string $value Account Name
     * @return CreateAccountRequest
     */
    public function setName($value){
        return $this->setParameter('name', $value);
    }

    /**
     * Get Type Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @return mixed
     */
    public function getType(){
        return $this->getParameter('type');
    }

    /**
     * Set Type Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @param string $value Account Type
     * @return CreateAccountRequest
     */
    public function setType($value){
        return $this->setParameter('type', $value);
    }

    /**
     * Get Tax Type Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @return mixed
     */
    public function getTaxType(){
        return $this->getParameter('tax_type');
    }

    /**
     * Set Tax Type Parameter from Parameter Bag
     * @see https://developer.intuit.com/app/developer/qbo/docs/api/accounting/all-entities/account
     * @param string $value Account Tax Type
     * @return CreateAccountRequest
     */
    public function setTaxType($value){
        return $this->setParameter('tax_type', $value);
    }


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('code', 'name', 'type');

        $this->issetParam('AcctNum', 'code');
        $this->issetParam('Name', 'name');
        $this->issetParam('AccountType', 'type');
        $this->issetParam('TaxCodeRef', 'tax_type');
        return $this->data;
    }

    /**
     * Send Data to Xero Endpoint and Retrieve Response via Response Interface
     * @param mixed $data Parameter Bag Variables After Validation
     * @return \Omnipay\Common\Message\ResponseInterface|CreateAccountResponse
     * @throws \QuickBooksOnline\API\Exception\IdsException
     */
    public function sendData($data)
    {
        $quickbooks = $this->createQuickbooksDataService();
        $quickbooks->throwExceptionOnError(true);
        $createParams = [];

        foreach ($data as $key => $value){
            $createParams[$key] = $data[$key];
        }

        $account = Account::create($createParams);
        $response = $quickbooks->Add($account);
        $error = $quickbooks->getLastError();
        if ($error) {
            $response = [
                'status' => $error->getHttpStatusCode(),
                'detail' => $error->getResponseBody()
            ];
        }

        return $this->createResponse($response);
    }

    /**
     * Create Generic Response from Quickbooks Endpoint
     * @param mixed $data Array Elements or Quickbooks Collection from Response
     * @return CreateAccountResponse
     */
    public function createResponse($data)
    {
        return $this->response = new CreateAccountResponse($this, $data);
    }
}