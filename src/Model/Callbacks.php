<?php

namespace ZoodPay\Api\SDK\Model;

class Callbacks implements \JsonSerializable
{
    private $error_url;
    private $success_url;
    private $ipn_url;
    private $refund_url;


    /**
     * @return string
     */
    public function getErrorUrl()
    {
        return $this->error_url;
    }

    /**
     * @param string $error_url
     */
    public function setErrorUrl($error_url)
    {
        $this->error_url = $error_url;
    }

    /**
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->success_url;
    }

    /**
     * @param string $success_url
     */
    public function setSuccessUrl($success_url)
    {
        $this->success_url = $success_url;
    }

    /**
     * @return string
     */
    public function getIpnUrl()
    {
        return $this->ipn_url;
    }

    /**
     * @param string $ipn_url
     */
    public function setIpnUrl($ipn_url)
    {
        $this->ipn_url = $ipn_url;
    }

    /**
     * @return string
     */
    public function getRefundUrl()
    {
        return $this->refund_url;
    }

    /**
     * @param string $refund_url
     */
    public function setRefundUrl($refund_url)
    {
        $this->refund_url = $refund_url;
    }
    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return  [
            "error_url"=> $this->getErrorUrl() ,
            "success_url"=>  $this->getSuccessUrl(),
            "ipn_url"=> $this->getIpnUrl(),
            "refund_url"=> $this->getRefundUrl() ,
        ];
    }
}