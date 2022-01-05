<?php

namespace ZoodPay\Api\SDK\Requests;

use ZoodPay\Api\SDK\Request;

class GetRefundById extends Request
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
    public function get($refundId)
    {
        $client     = $this->getClient();
        $version    = $this->merchant->getApiVersion();
        return $client->get("/$version/refunds/$refundId");
    }
}