<?php

namespace ZoodPay\Api\SDK\Requests;

use ZoodPay\Api\SDK\Request;

class GetTransactionById extends Request
{   
    /**
     * 
     */
    public function __construct($data = [], $merchant = null)
    {
        parent::__construct($data, $merchant);
        $this->setAuthHeader();
    }

    /**
     * Get configuration.
     * 
     * @return 
     */
    public function get($transactionId)
    {
        $client     = $this->getClient();
        $version    = $this->merchant->getApiVersion();
        return $client->get("/$version/transactions/$transactionId");
    }
}