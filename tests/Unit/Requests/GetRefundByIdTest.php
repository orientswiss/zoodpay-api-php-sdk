<?php


use ZoodPay\Api\SDK\Requests\GetRefundById;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/feeder.php';

class GetRefundByIdTest extends TestCase
{

    public function testGetRefundByID()
    {

        $request = new GetRefundById();
        $response = $request->get('6111fb94afb79');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $this->assertEquals(200, $response->getStatusCode(), "Refund Not Available");
        $this->assertStringContainsString("refund_id", $body, "Refund do not have refund id");
        $this->assertStringContainsString("refund", $body, "refund Do not have refund details");
        echo "Status Code: " . $statusCode . PHP_EOL;
        echo "Refund Response: ";
        print_r($body);
        echo PHP_EOL;
    }
}
