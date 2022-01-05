<?php

namespace ZoodPay\Api\SDK;

use Exception;
use PHPUnit\Framework\TestCase;

class MerchantTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testMerchant()
    {
        $merchant = new Merchant("test", "secret", "salt_key", "https://sandbox-api.zoodpay.com", "v0","UZ");
        $isSetup = $merchant->isSetup();
        $this->assertEquals(true, $isSetup, "Setup was not Completed");

        if ($isSetup) {
            $apiVersion = $merchant->getApiVersion();
            $merchantKey = $merchant->getMerchantId();
            $merchantSecretKey = $merchant->getSecretKey();
            $apiEndPoint = $merchant->getApiEndPoint();
            $limits = $merchant->getLimits($merchant->getMarketCode(), "ZPI");
            $this->assertIsString($merchantKey, "Merchant Key Not Available");
            $this->assertIsString($merchantSecretKey, "Merchant Secret Key Not Available");
            $this->assertIsString($apiEndPoint, "API EndPoint Is not available");
            $this->assertIsString($apiVersion, "API Version is not Available");

            $this->assertArrayHasKey("min_limit", $limits, "Min Limit Not Available");
            $this->assertArrayHasKey("max_limit", $limits, "Max Limit Not Available");
            $this->assertArrayHasKey("updated_at", $limits, "Updated At Not Available");


        }


    }

}
