<?php


use ZoodPay\Api\SDK\Requests\HealthCheck;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

class HealthCheckTest extends TestCase
{


    public function testGet()
    {
        $request = new HealthCheck();
        $response = $request->get();
        $this->assertEquals("200", $response->getStatusCode(), "Status Code is Not 200");
        $this->assertEquals("OK", $response->getReasonPhrase(), "API Is Not Healthy");
    }

}
