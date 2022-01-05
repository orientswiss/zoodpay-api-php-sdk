<?php

namespace ZoodPay\Api\SDK\Requests;

use ZoodPay\Api\SDK\Request;

class CreateTransaction extends Request
{   
    /**
     * 
     */
    public function __construct($data = [], $merchant = null)
    {
        parent::__construct($data, $merchant);
        $this->setAuthHeader();
        $this->setApplicationHeader();

        ;
    }


    /**
     * @param $billing
     * @param $customer
     * @param $items
     * @param $order
     * @param $shipping
     * @param $shippingService
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($billing, $customer, $items, $order, $shipping, $shippingService)
    {

        $this->data = json_encode( [
            "billing" => $billing,
            "customer" => $customer,
            "items" => [$items],
            "order" => $order,
            "shipping" => $shipping,
            "shipping_service" => $shippingService,
        ],false);
        echo "API ". $this->data;
        $array = json_decode($this->data,true);
        $client     = $this->getClient();
        $version    = $this->merchant->getApiVersion();


      return $client->post("/$version/transactions", ['body' => $this->data]);

    }
}