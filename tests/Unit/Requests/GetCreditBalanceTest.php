<?php


use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Model\Credit;
use ZoodPay\Api\SDK\Requests\GetCreditBalance;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2) . '/feeder.php';

class GetCreditBalanceTest extends TestCase
{
    public function testCredit()
    {
        $config = new  Config();
        $marketCode= $config::get('market_code');
        $feed = feedData($marketCode);
        $creditModel = new Credit();
        $creditModel->setCustomerMobile($feed["phone"]);
        $creditModel->setMarketCode($feed["country"]);
        $creditReq = new GetCreditBalance($creditModel->jsonSerialize());
        $response = $creditReq->get();
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $this->assertEquals(200, $response->getStatusCode(), "Issue happened while fetching Credit Balance");
        $this->assertStringContainsString("credit_balance", $body, "Credit_balance not available");
        $this->assertStringContainsString("service_code", $body, "service_code not available");
        $this->assertStringContainsString("currency", $body, "currency not available");
        $this->assertStringContainsString("amount", $body, "amount not available");
        echo "Status Code: " . $response->getStatusCode() . PHP_EOL;
        echo "Response: ";
        print_r($body);
        echo PHP_EOL;

    }
}
