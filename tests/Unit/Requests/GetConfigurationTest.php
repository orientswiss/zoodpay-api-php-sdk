<?php


use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Requests\GetConfiguration;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/feeder.php';

class GetConfigurationTest extends TestCase
{
    public function testGet()
    {
        $config = new  Config();
        $marketCode= $config::get('market_code');
        $feed = feedData($marketCode);
        $request = new GetConfiguration(['market_code' => $feed["country"]]);
        $response = $request->get();
        $body = $response->getBody()->getContents();
        $bodyArray = json_decode($body, true);
        $this->assertIsArray($bodyArray['configuration'], "Configuration Did not Fetched");
        $this->assertEquals("200", $response->getStatusCode(), "Status Code is Not 200");

    }

}
