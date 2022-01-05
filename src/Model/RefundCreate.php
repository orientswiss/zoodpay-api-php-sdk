<?php

namespace ZoodPay\Api\SDK\Model;

use JsonSerializable;

class RefundCreate implements JsonSerializable
{

    private $merchant_refund_reference;
    private $reason;
    private $refund_amount;
    private $request_id;
    private $transaction_id;


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "merchant_refund_reference" => $this->getMerchantRefundReference(),
            "reason" => $this->getReason(),
            "refund_amount"=> $this->getRefundAmount(),
            "request_id"=> $this->getRequestId(),
            "transaction_id"=> $this->getTransactionId()
        ];
    }

    /**
     * @return string
     */
    public function getMerchantRefundReference()
    {
        return $this->merchant_refund_reference;
    }

    /**
     * @param string $merchant_refund_reference
     */
    public function setMerchantRefundReference($merchant_refund_reference)
    {
        $this->merchant_refund_reference = $merchant_refund_reference;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return int
     */
    public function getRefundAmount()
    {
        return $this->refund_amount;
    }

    /**
     * @param int $refund_amount
     */
    public function setRefundAmount($refund_amount)
    {
        $this->refund_amount = $refund_amount;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * @param string $request_id
     */
    public function setRequestId($request_id)
    {
        $this->request_id = $request_id;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @param string $transaction_id
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }
}