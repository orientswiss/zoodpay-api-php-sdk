# PHP SDK for ZoodPay API
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zoodpay/api-php-sdk?style=flat-square)](https://packagist.org/packages/zoodpay/api-php-sdk)


## ZoodPay API


ZoodPay wants to provide its payment solution to every online business who may be interested in it. ZoodPay API v0 is the latest version which offers our latest features.

[ZoodPay API Documentation](https://api.zoodpay.com/)

[ZoodPay API API Simulator](https://api.zoodpay.com/docs)


## Requirement

```bash
"Php Extension": curl, json , openssl
"php" : >=5.6,
```
## Installation
You can install the package via composer:
```bash
composer require zoodpay/api-php-sdk
```
## Setup
You can setup the SDK:
### 
1. Through .env file.  
- Copy and create .env from sample.env.php and load it.
- Change the values accordingly.
- The SDK will load the values automaticly. 
2. Through .env.php
- Copy and create .env.php from sample.env.php 
- Change the values accordingly.
- The SDK will load the values automaticly.
3. Through Config Setter.
```php
$config = new  Config();
$merchantKey = $config::get('merchant_id');
$merchantSecretKey = $config::get('secret_key');
$merchantSaltKey = $config::get('salt_key');
$apiBaseUrl = $config::get('api_endpoint');
$apiVersion = $config::get('api_version');
$marketCode= $config::get('market_code');
$dbHost = $config::get('db_host');
$dbPort = $config::get('db_port');
$dbDataBase = $config::get('db_database');
$dbTable = $config::get('db_table_prefix');
$dbUser = $config::get('db_user');
$dbPassword = $config::get('db_password');
```

## Usage

``` php
require __DIR__ . '/vendor/autoload.php';

use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Model\BillingShipping;
use ZoodPay\Api\SDK\Model\Credit;
use ZoodPay\Api\SDK\Model\Customer;
use Zoodpay\Api\SDK\Model\Delivery;
use ZoodPay\Api\SDK\Model\Items;
use ZoodPay\Api\SDK\Model\Order;
use ZoodPay\Api\SDK\Model\RefundCreate;
use ZoodPay\Api\SDK\Model\ShippingService;
use ZoodPay\Api\SDK\PersistentStorage;

use ZoodPay\Api\SDK\Requests\HealthCheck;
use ZoodPay\Api\SDK\Requests\GetConfiguration;
use ZoodPay\Api\SDK\Requests\GetTransactionById;
use ZoodPay\Api\SDK\Requests\GetRefundById;
use ZoodPay\Api\SDK\Requests\GetCreditBalance;
use ZoodPay\Api\SDK\Requests\SetTransactionDelivery;
use ZoodPay\Api\SDK\Requests\CreateTransaction;
use ZoodPay\Api\SDK\Requests\CreateRefund;
use ZoodPay\Api\SDK\Requests\Signature;

// Health check
try{
    echo "Health Check" . PHP_EOL;
    $request = new HealthCheck();
    $response = $request->get();

    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo "Error: " . $e->getMessage();
    die;
}

// Get configuration
try{
    echo "Get Configuration" . PHP_EOL;
    $request = new GetConfiguration(['market_code' => 'UZ']);
    $response = $request->get();
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
    

// Check database connection & fetch order limit from database.
try{
    echo "Get Limits" . PHP_EOL;
    PersistentStorage::testConnection();

    // Get order limits if Persistent Storage is configured.
    $limits = PersistentStorage::getLimits('UZ', 'ZPI');
    echo "Response: "; print_r($limits);
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}

// Get transaction status
try{
    echo "Get transaction status" . PHP_EOL;
    $request = new GetTransactionById();
    $response = $request->get('6041db6798805');
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}

// Get refund status
try{
    echo "Get refund status" . PHP_EOL;
    $request = new GetRefundById();
    $response = $request->get('5f47b1ca6cf38');
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}



$creditModel = new Credit();
$creditModel->setCustomerMobile("998989898895");
$creditModel->setMarketCode("UZ");

// Get credit balance
try{
    echo "Get Credit balance" . PHP_EOL;
    $request = new GetCreditBalance($creditModel->jsonSerialize());
    $response = $request->get();
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
    
// Update transaction delivery
$delivery = new Delivery();
$delivery->setDeliveredAt("2021-08-10 10:42:10");
$delivery->setFinalCaptureAmount(10815);
try{
    echo "Update transaction delivery" . PHP_EOL;
    $request = new SetTransactionDelivery($delivery->jsonSerialize());
    $response = $request->set('639541327461611');
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
    
// Create transaction
$billing = new BillingShipping();

$billing->setName("Test User");
$billing->setPhoneNumber("998993123456");
$billing->setAddressLine1("Test Address 1");
$billing->setAddressLine2("Test Address 2");
$billing->setCity("Test City");
$billing->setCountryCode("UZ");
$billing->setState("Test");
$billing->setZipcode("Test-123");

$order = new Order();
$order->setAmount(600.00);
$order->setCurrency("UZS");
$order->setDiscountAmount(1.00);
$order->setLang("en");
$order->setMarketCode("UZ");
$order->setMerchantReferenceNo("Test1234");
$order->setServiceCode("ZPI");
$order->setShippingAmount(1.00);
$order->setTaxAmount(1.00);
$signatureRequest = new Signature();
$order =  $signatureRequest->CreateTransactionSignature($order);

$shipping = $billing;

$customer = new Customer();
$customer->setCustomerDob("2000-12-23");
$customer->setCustomerEmail("test@zoodpay.com");
$customer->setCustomerPhone("+998993123456");
$customer->setFirstName("Test");
$customer->setLastName("TestLast");
$customer->setCustomerPid(585478965);

$shippingService = new ShippingService();
$shippingService->setName("Test Service");
$shippingService->setPriority("Express");
$shippingService->setShippedAt("Date");
$shippingService->setTracking("HHHHHHH0-hhsh");

$items[] = new Items();
$items[0]->setName("Test Product");
$items[0]->setCategories(["Products-Category1"]);
$items[0]->setCurrencyCode("UZS");
$items[0]->setDiscountAmount(1.00);
$items[0]->setPrice(600.00);
$items[0]->setQuantity(1.00);
$items[0]->setSku("Test-SKU");
$items[0]->setTaxAmount(1.00);

$callbacks = new Callbacks();
$callbacks->setErrorUrl("https://zoodpay.com");
$callbacks->setSuccessUrl("https://zoodpay.com");
$callbacks->setIpnUrl("https://zoodpay.com");
$callbacks->setRefundUrl("https://zoodpay.com");

try{
    echo "Create transaction" . PHP_EOL;
    $transactionRequest = new CreateTransaction();
    $response = $transactionRequest->create($billing,$customer,$items,$order,$shipping,$shippingService,$callbacks);
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}

catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}

// Create refund


$refundModel = new RefundCreate();
$refundModel->setMerchantRefundReference("3000000004");
$refundModel->setReason("Test Unit");
$refundModel->setRefundAmount(1000);
$refundModel->setRequestId("3000000004-refund");
$refundModel->setTransactionId("639541327461611");
try{
    echo "Create refund" . PHP_EOL;
    $request = new CreateRefund();
    $response = $request->create($refundModel);
    echo "Status Code: " . $response->getStatusCode() . PHP_EOL; 
    echo "Response: "; print_r($response->getBody()->getContents()); 
    echo PHP_EOL;
}
catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}


//ZoodPay Transaction Response Signature
echo "ZoodPay Transaction Response Signature" . PHP_EOL;
$signatureRequest = new Signature();
try {
    $ResponseSign = $signatureRequest->ZoodPayResponseSignature("UZ", "UZS", "123.00", "12345", "1133333333333");
} catch (\ZoodPay\Api\SDK\Exception\InvalidArgumentException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}

echo "Signature: "; print_r($ResponseSign);
echo PHP_EOL;


//ZoodPay Refund Response Signature

echo "ZoodPay Refund Response Signature" . PHP_EOL;
$RefundSignatureRequest = new Signature();
try {
    $ResponseSign = $RefundSignatureRequest->ZoodPayRefundResponseSignature("000001-Refund", "1000.00", "Approved", "ZoodPay-Refund-ID");
} catch (\ZoodPay\Api\SDK\Exception\InvalidArgumentException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}


echo "Refund Signature: "; print_r($ResponseSign);
echo PHP_EOL;
```
### Security
If you discover any security related issues, please email integration@zoodpay.com instead of using the issue tracker.

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
