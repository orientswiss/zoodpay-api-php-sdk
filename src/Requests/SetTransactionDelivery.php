<?php

namespace ZoodPay\Api\SDK\Requests;

use ZoodPay\Api\SDK\Request;

class SetTransactionDelivery extends Request
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
    public function set($transactionId)
    {
        $client     = $this->getClient();
        $version    = $this->merchant->getApiVersion();
        return $client->put("/$version/transactions/$transactionId/delivery", ['json' => $this->data]);
    }
}