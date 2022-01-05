<?php

namespace Zoodpay\Api\SDK\Requests;

use PHPUnit\Framework\TestCase;
use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Exception\InvalidArgumentException;
use ZoodPay\Api\SDK\Model\Order;
use ZoodPay\Api\SDK\Request;
use ZoodPay\Api\SDK\Requests\Signature;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

require_once dirname(__DIR__, 2) . '/feeder.php';

class CreateSignatureTest extends TestCase
{

    /**
     * @throws InvalidArgumentException
     */
    public function testCreateTransactionSignature()
    {

        $config = new  Config();
        $marketCode= $config::get('market_code');
        $feed = feedData($marketCode);
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
        $this->assertCount(128, str_split($order->getSignature()), "Signature did Not Generate");

    }

    /**
     * @throws InvalidArgumentException
     */
    public function testZoodPayResponseSignature()
    {
        $config = new  Config();
        $marketCode= $config::get('market_code');
        $feed = feedData($marketCode);
        $signatureRequest = new Signature();
        $ResponseSign = $signatureRequest->ZoodPayResponseSignature($feed["country"], $feed["currency"], $feed["amount"], generateRandomString(), generateRandomString());
        $this->assertCount(128, str_split($ResponseSign), "Signature did Not Generate");
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testZoodPayRefundResponseSignature()
    {
        $config = new  Config();
        $marketCode= $config::get('market_code');
        $feed = feedData($marketCode);
        $signatureRequest = new Signature();
        $ResponseSign = $signatureRequest->ZoodPayRefundResponseSignature("000001-Refund", $feed["amount"], "Approved", "ZoodPay-Refund-ID");
        $this->assertCount(128, str_split($ResponseSign), "Signature did Not Generate");
    }
}
