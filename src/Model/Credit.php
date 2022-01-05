<?php

namespace ZoodPay\Api\SDK\Model;

use JsonSerializable;

class Credit implements JsonSerializable
{

    private $customer_mobile;
    private $market_code;


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return  [
            "customer_mobile"   => $this->getCustomerMobile(),
            "market_code"       => $this->getMarketCode()
        ];
    }

    /**
     * @return mixed
     */
    public function getCustomerMobile()
    {
        return $this->customer_mobile;
    }

    /**
     * @param mixed $customer_mobile
     */
    public function setCustomerMobile($customer_mobile)
    {
        $this->customer_mobile = $customer_mobile;
    }

    /**
     * @return mixed
     */
    public function getMarketCode()
    {
        return $this->market_code;
    }

    /**
     * @param mixed $market_code
     */
    public function setMarketCode($market_code)
    {
        $this->market_code = $market_code;
    }
}