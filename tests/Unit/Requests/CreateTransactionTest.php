<?php


use GuzzleHttp\Exception\GuzzleException;
use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Model\BillingShipping;
use ZoodPay\Api\SDK\Model\Customer;
use ZoodPay\Api\SDK\Model\Items;

use ZoodPay\Api\SDK\Model\Order;
use ZoodPay\Api\SDK\Model\ShippingService;
use ZoodPay\Api\SDK\Request;
use ZoodPay\Api\SDK\Requests\CreateTransaction;
use PHPUnit\Framework\TestCase;
use ZoodPay\Api\SDK\Requests\Signature;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

require_once dirname(__DIR__, 2) . '/feeder.php';

class CreateTransactionTest extends TestCase
{

    /**
     * @throws GuzzleException
     * @throws \ZoodPay\Api\SDK\Exception\InvalidArgumentException
     */
    public function testCreate()
    {

        $config = new  Config();
        $marketCode= $config::get('market_code');
        $feed = feedData($marketCode);
        $billing = new BillingShipping();
        $billing->setName("Test User");
        $billing->setPhoneNumber($feed["phone"]);
        $billing->setAddressLine1("Test Address 1");
        $billing->setAddressLine2("Test Address 2");
        $billing->setCity("Test City");
        $billing->setCountryCode($feed["country"]);
        $billing->setState("Test");
        $billing->setZipcode("Test-123");

        $order = new Order();
        $order->setAmount($feed["amount"]);
        $order->setCurrency($feed["currency"]);
        $order->setDiscountAmount(0.00);
        $order->setLang("en");
        $order->setMarketCode($feed["country"]);
        $order->setMerchantReferenceNo("Test_" . generateRandomString());
        $order->setServiceCode("ZPI");
        $order->setShippingAmount(0.00);
        $order->setTaxAmount(0.00);
        $signatureRequest = new Signature();
        $order = $signatureRequest->CreateTransactionSignature($order);

        $shipping = $billing;

        $customer = new Customer();
        $customer->setCustomerDob("2000-12-23");
        $customer->setCustomerEmail("test3@zoodpay.com");
        $customer->setCustomerPhone($feed["phone"]);
        $customer->setFirstName("Test");
        $customer->setLastName("TestLast");
        //$customer->setCustomerPid(585478965);

        $shippingService = new ShippingService();
        $shippingService->setName("Test Service");
        $shippingService->setPriority("Express");
        $shippingService->setShippedAt("Date");
        $shippingService->setTracking("HHHHHHH0-hhsh");

        $items = new Items();
        $items->setName("Test Product" . generateRandomString());
        $items->setCategories(["Products-Category1"]);
        $items->setCurrencyCode($feed["currency"]);
        $items->setDiscountAmount(0.00);
        $items->setPrice($feed["amount"]);
        $items->setQuantity(1.00);
        $items->setSku("Test-SKU" . generateRandomString());
        $items->setTaxAmount(0.00);

        $transactionRequest = new CreateTransaction();
        $response = $transactionRequest->create($billing, $customer, $items, $order, $shipping, $shippingService);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $this->assertEquals(201, $statusCode, "Transaction did not created");
        $this->assertStringContainsString("transaction_id", $body, "Transaction do not have transaction id");
        $this->assertStringContainsString("payment_url", $body, "Transaction Do not have Payment URL");
        $this->assertStringContainsString("expiry_time", $body, "Transaction Do not have Expiry Time");
        $this->assertStringContainsString("session_token", $body, "Transaction Do not have Session Token");
        $this->assertStringContainsString("signature", $body, "Transaction Do not have Signature");


        echo "Status Code: " . $statusCode . PHP_EOL;
        echo "Response: ";
        print_r($body);
        echo PHP_EOL;


        $info = "M";

    }


}
