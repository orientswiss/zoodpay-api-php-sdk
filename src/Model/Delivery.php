<?php

namespace Zoodpay\Api\SDK\Model;

use JsonSerializable;

class Delivery implements JsonSerializable
{
    private $delivered_at;
    private $final_capture_amount;

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
     return [  "delivered_at" => $this->getDeliveredAt(),
    "final_capture_amount" => $this->getFinalCaptureAmount()];
    }

    /**
     * @return mixed
     */
    public function getDeliveredAt()
    {
        return $this->delivered_at;
    }

    /**
     * @param string  $delivered_at (Format : YYYY-M-D H:M:S )
     */
    public function setDeliveredAt($delivered_at)
    {
        $this->delivered_at = $delivered_at;
    }

    /**
     * @return mixed
     */
    public function getFinalCaptureAmount()
    {
        return $this->final_capture_amount;
    }

    /**
     * @param mixed $final_capture_amount
     */
    public function setFinalCaptureAmount($final_capture_amount)
    {
        $this->final_capture_amount = $final_capture_amount;
    }
}