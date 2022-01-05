<?php

namespace ZoodPay\Api\SDK\Requests;

use Zoodpay\Api\SDK\Model\RefundCreate;
use ZoodPay\Api\SDK\Request;

class CreateRefund extends Request
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
     * @param RefundCreate $refund
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($refund)
    {
        $this->data = json_encode( $refund->jsonSerialize());


        $client     = $this->getClient();
        $version    = $this->merchant->getApiVersion();
        return $client->post("/$version/refunds", ['body' => $this->data]);
    }
}