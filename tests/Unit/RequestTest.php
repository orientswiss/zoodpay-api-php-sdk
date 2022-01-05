<?php

namespace ZoodPay\Api\SDK;

use PHPUnit\Framework\TestCase;


class RequestTest extends TestCase
{

    public function testGetMerchant()
    {

        $request = new Request();
        $apiVersion = $request::getApiVersion();
        $merchantKey = $request::getMerchantId();
        $merchantSecretKey = $request::getSecretKey();
        $apiEndPoint = $request::getApiEndPoint();
        $platformInfo = $request::getPlatformDetailsAsString();
        $this->assertIsString($merchantKey, "Merchant Key Not Available");
        $this->assertIsString($merchantSecretKey, "Merchant Secret Key Not Available");
        $this->assertIsString($apiEndPoint, "API EndPoint Is not available");
        $this->assertIsString($apiVersion, "API Version is not Available");
        $this->assertIsString($platformInfo, "Platform Info Is not Available");


    }

}
