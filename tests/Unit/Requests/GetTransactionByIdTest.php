<?php


use ZoodPay\Api\SDK\Requests\GetTransactionById;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/feeder.php';

class GetTransactionByIdTest extends TestCase
{

    /**
     * @var mixed
     */
    private $transaction;

    public function setUp()
    {

        $this->transaction = createTestTransaction();

    }

    public function testGetTransactionById()
    {
        $request = new GetTransactionById();
        $response = $request->get($this->transaction['transaction_id']);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $this->assertEquals(200, $statusCode, "Transaction Not Available");
        $this->assertStringContainsString("transaction_id", $body, "Transaction do not have transaction id");
        $this->assertStringContainsString("status", $body, "Transaction Do not have status");
        $this->assertStringContainsString("amount", $body, "Transaction Do not have amount");
        $this->assertStringContainsString("created_at", $body, "Transaction Do not have created_at");
        echo "Status Code: " . $statusCode . PHP_EOL;
        echo "Response: ";
        print_r($body);
        echo PHP_EOL;
    }

}
