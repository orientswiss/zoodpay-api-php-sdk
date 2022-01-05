<?php


namespace ZoodPay\Api\SDK\Model;


use JsonSerializable;

class ShippingService implements JsonSerializable
{
private $name;
private $priority;
private $shipped_at;
private $tracking;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getShippedAt()
    {
        return $this->shipped_at;
    }

    /**
     * @param string $shipped_at
     */
    public function setShippedAt($shipped_at)
    {
        $this->shipped_at = $shipped_at;
    }

    /**
     * @return string
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * @param string $tracking
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return  [
            "name"=> $this->getName(),
            "priority"=> $this->getPriority(),
            "shipped_at"=>$this->getShippedAt(),
            "tracking"=>$this->getTracking()
        ];


    }
}