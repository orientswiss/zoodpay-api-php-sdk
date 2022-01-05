<?php

namespace ZoodPay\Api\SDK;

use ZoodPay\Api\SDK\Http;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit;

class HttpTest extends TestCase
{

    public function testHttp()
    {


        $httpRequest = new Http();
        $httpRequest::addPlatformDetail("WordPress", "5.0");
        $response = $httpRequest::getPlatformDetailsAsString();

        self::assertIsString($response, "Platform Is Set");

        echo "Get Platform Details Response: ";
        echo json_encode($response);
        echo PHP_EOL;

        $httpRequest::clearPlatformDetails();
        $response = $httpRequest::getPlatformDetailsAsString();

        self::assertIsString($response, "Platform Is Cleared");

        echo "Get Platform Details Response after Platform Clearance: ";
        echo json_encode($response);
        echo PHP_EOL;
    }


}
