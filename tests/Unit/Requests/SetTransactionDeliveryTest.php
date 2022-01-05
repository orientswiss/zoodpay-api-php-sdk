<?php


use ZoodPay\Api\SDK\Model\Delivery;
use ZoodPay\Api\SDK\Requests\SetTransactionDelivery;
use PHPUnit\Framework\TestCase;

class SetTransactionDeliveryTest extends TestCase
{

    public function testSetDelivery()
    {
        $delivery = new Delivery();
        $delivery->setDeliveredAt("2021-08-10 10:42:10");
        $delivery->setFinalCaptureAmount(10815);
        $deliveryRequest = new SetTransactionDelivery($delivery->jsonSerialize());
        $response = $deliveryRequest->set('639541327461611');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $this->assertEquals(200, $statusCode, "Delivery did not Happened");
        $this->assertStringContainsString("transaction_id", $body, "Response do not have transaction id");
        $this->assertStringContainsString("status", $body, "Response Do not have status");
        $this->assertStringContainsString("original_amount", $body, "Response Do not have original_amount");
        $this->assertStringContainsString("delivered_at", $body, "Response Do not have delivered_at");
        $this->assertStringContainsString("final_capture_amount", $body, "Response Do not have final_capture_amount");
        echo "Status Code: " . $statusCode . PHP_EOL;
        echo "Response: ";
        print_r($body);
        echo PHP_EOL;
    }
}
