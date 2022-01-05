<?php

namespace ZoodPay\Api\SDK\Requests;

use ZoodPay\Api\SDK\Request;

class HealthCheck extends Request
{   
    /**
     * 
     */
    public function __construct($data = [], $merchant = null)
    {
        parent::__construct($data, $merchant);
    }

    /**
     * Get configuration.
     * 
     * @return 
     */
    public function get()
    {
        $client     = $this->getClient();
        return $client->get('/healthcheck');
    }
}