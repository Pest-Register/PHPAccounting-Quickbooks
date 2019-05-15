<?php

namespace PHPAccounting\XERO\Message\Invoices\Responses;


use PHPAccounting\Common\Message\AbstractResponse;
use PHPAccounting\Common\Message\RequestInterface;

class CreateInvoiceResponse extends AbstractResponse
{

    public function __construct(RequestInterface $request, $data, $headers = [])
    {
        parent::__construct($request, json_decode($data, true), $headers);
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data != null;
    }
}