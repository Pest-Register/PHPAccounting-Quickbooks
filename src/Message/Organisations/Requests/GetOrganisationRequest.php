<?php
namespace PHPAccounting\Quickbooks\Message\Organisations\Requests;


use PHPAccounting\Quickbooks\Message\AbstractRequest;
use PHPAccounting\Quickbooks\Message\Accounts\Responses\GetAccountResponse;
use PHPAccounting\Quickbooks\Message\Organisations\Responses\GetOrganisationResponse;
use QuickBooksOnline\API\Exception\IdsException;

class GetOrganisationRequest extends AbstractRequest
{


    /**
     * Send Data to Quickbooks Endpoint and Retrieve Response via Response Interface
     * @param mixed $data Parameter Bag Variables After Validation
     * @return \Omnipay\Common\Message\ResponseInterface|GetOrganisationResponse
     * @throws IdsException
     */
    public function sendData($data)
    {
        $quickbooks = $this->createQuickbooksDataService();
        $quickbooks->throwExceptionOnError(true);

        $response = $quickbooks->getCompanyInfo();
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
     * Create Generic Response from Xero Endpoint
     * @param mixed $data Array Elements or Xero Collection from Response
     * @return GetOrganisationResponse
     */
    public function createResponse($data)
    {
        return $this->response = new GetOrganisationResponse($this, $data);
    }
}