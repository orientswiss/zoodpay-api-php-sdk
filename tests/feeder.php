<?php

use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Model\BillingShipping;
use ZoodPay\Api\SDK\Model\Callbacks;
use ZoodPay\Api\SDK\Model\Customer;
use ZoodPay\Api\SDK\Model\Items;
use ZoodPay\Api\SDK\Model\Order;
use ZoodPay\Api\SDK\Model\ShippingService;
use ZoodPay\Api\SDK\Requests\CreateTransaction;
use ZoodPay\Api\SDK\Requests\Signature;

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function createTestTransaction()
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


    $items[]= new Items();
    $items[0]->setName("Test Product". generateRandomString() );
    $items[0]->setCategories(["Products-Category1"]);
    $items[0]->setCurrencyCode($feed["currency"]);
    $items[0]->setDiscountAmount(1.00);
    $items[0]->setPrice($feed["amount"]);
    $items[0]->setQuantity(1.00);
    $items[0]->setSku("Test-SKU". generateRandomString());
    $items[0]->setTaxAmount(1.00);


    $callbacks = new Callbacks();
    $callbacks->setErrorUrl("https://zoodpay.com");
    $callbacks->setSuccessUrl("https://zoodpay.com");
    $callbacks->setIpnUrl("https://zoodpay.com");
    $callbacks->setRefundUrl("https://zoodpay.com");

    $transactionRequest = new CreateTransaction();
    $response = $transactionRequest->create($billing, $customer, $items, $order, $shipping, $shippingService,$callbacks);
    return json_decode($response->getBody()->getContents(), true);

}

function feedData($marketCode)
{
    switch ($marketCode) {
        case "UZ" :
        {
            return ["phone" => "998365896609", "currency" => "UZS", "country" => "UZ",  "amount" => "250000"];
        }
        case "KZ" :
        {
            return ["phone" => "77778212199", "currency" => "KZT", "country" => "KZ", "amount" => "10000"];
        }
        case "JO" :
        {
            return ["phone" => "962790802644", "currency" => "JOD" , "country" => "JO", "amount" => "15"];
        }
        case "LB" :
        {
            return ["phone" => "96164325686", "currency" => "LBP" , "country" => "LB", "amount" => "15"];
        }

        case "IQ" :
        {
            return ["phone" => "9649899232311", "currency" => "IQD" , "country" => "IQ", "amount" => "1000"];
        }
    }

}