<?php


use GuzzleHttp\Exception\GuzzleException;
use ZoodPay\Api\SDK\Model\RefundCreate;
use ZoodPay\Api\SDK\Requests\CreateRefund;
use PHPUnit\Framework\TestCase;
use ZoodPay\Api\SDK\Requests\GetTransactionById;

require_once dirname(__DIR__, 2) . '/feeder.php';

class RefundCreateTest extends TestCase
{
    /**
     * @var mixed
     */
    private $transaction;

    public function setUp()
    {

        $transaction = createTestTransaction();
        echo "\n" . "Created Transaction Response: " . json_encode($transaction);
        $request = new GetTransactionById();
        $this->transaction = json_decode(($request->get($transaction['transaction_id'])->getBody()), true);

    }

    /**
     * @throws GuzzleException
     */
    public function testRefund()
    {


        echo "\n" . "transaction Details: " . json_encode($this->transaction);

        $refund = generateRandomString();
        $refundModel = new RefundCreate();
        $refundModel->setMerchantRefundReference($refund);
        $refundModel->setReason("Test Unit");
        $refundModel->setRefundAmount($this->transaction["amount"]);
        $refundModel->setRequestId($refund . "-refund");
        $refundModel->setTransactionId($this->transaction["transaction_id"]);

        $createRefundRequest = new CreateRefund();
        $response = $createRefundRequest->create($refundModel);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $this->assertEquals(201, $statusCode, "Refund did not created");
        $this->assertStringContainsString("refund_id", $body, "Refund do not have refund id");
        $this->assertStringContainsString("refund", $body, "refund Do not have refund details");


        echo "Status Code: " . $response->getStatusCode() . PHP_EOL;
        echo "Response: ";
        print_r($body);
        echo PHP_EOL;

    }

}
