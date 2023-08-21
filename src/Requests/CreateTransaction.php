<?php

namespace ZoodPay\Api\SDK\Requests;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
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
    }


    /**
     * @param $billing
     * @param $customer
     * @param $items
     * @param $order
     * @param $shipping
     * @param $shippingService
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function create($billing, $customer, $items, $order, $shipping, $shippingService, $callbacks)
    {

        $this->data = json_encode(["billing" => $billing, "customer" => $customer, "items" => $items, "order" => $order, "shipping" => $shipping, "shipping_service" => $shippingService, "callbacks" => $callbacks], false);

        $client = $this->getClient();
        $version = $this->merchant->getApiVersion();

        return $client->post("/$version/transactions", ['body' => $this->data]);

    }
}