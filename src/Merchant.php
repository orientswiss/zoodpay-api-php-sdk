<?php

namespace ZoodPay\Api\SDK;

use ZoodPay\Api\SDK\PersistentStorage;
use ZoodPay\Api\SDK\Requests\GetConfiguration;

class Merchant 
{
    /**
     * Merchant credentials
     */
    protected $merchantId; // Merchant ID
    protected $secretKey;  // Secret Key
    protected $saltKey;
    protected $apiEndPoint;
    protected $apiVersion;
    protected $marketCode;
    const SERVICES = ['ZPI', 'PAD'];

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param string $merchantId
     * @return Merchant
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     * @return Merchant
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndPoint()
    {
        return $this->apiEndPoint;
    }

    /**
     * @param string $apiEndPoint
     * @return Merchant
     */
    public function setApiEndPoint($apiEndPoint)
    {
        $this->apiEndPoint = $apiEndPoint;

        return $this;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @param string $apiEndPoint
     * @return Merchant
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSaltKey()
    {
        return $this->saltKey;
    }

    /**
     * @param mixed $saltKey
     * @return Merchant
     */
    public function setSaltKey($saltKey)
    {
        $this->saltKey = $saltKey;
        return $this;
    }

    public function __construct($merchantId = null, $secretKey = null,$saltKey = null , $apiEndPoint = null, $apiVersion = null, $marketCode = null)
    {
        if (! is_null($merchantId) ) {
            $this->merchantId = $merchantId;

        }
        if (! is_null($secretKey) ) {

            $this->secretKey = $secretKey;
        }
           if (! is_null($saltKey) ) {

            $this->saltKey = $saltKey;
        }


        if (! is_null($apiEndPoint)) {
            $this->apiEndPoint = $apiEndPoint;
        }

        if (! is_null($apiVersion)) {
            $this->apiVersion = $apiVersion;
        }
         if (! is_null($marketCode)) {
            $this->marketCode = $marketCode;
        }

    }

    /**
     * @return bool
     */
    public function isSetup()
    {
        return ! is_null($this->merchantId) && ! is_null($this->secretKey) && ! is_null($this->saltKey)
            && ! is_null($this->apiEndPoint) && ! is_null($this->apiVersion);
    }

    /**
     * @return array[min, max]
     */
    public function getLimits($marketCode, $service)
    {
        $marketCode = strtoupper($marketCode);
        $service = strtoupper($service);

        if(!in_array($service, self::SERVICES)){
            throw new InvalidArgumentException("Unexpected value '{$service}' for 'service' given; expected one of '" . implode("', '", self::SERVICES) . "' (case insensitive)");
        }

        if(PersistentStorage::isConfigured()){
            $limits =   PersistentStorage::getLimits($marketCode, $service);
           return $limits;
        }
        else if($this->isSetup()) {
            $request = new GetConfiguration(['market_code' => $marketCode]);
            $response = $request->get();
            $configuration = json_decode($response->getBody()->getContents())->configuration;

            foreach($configuration as $config)
            {
                if(strtolower($service) == strtolower($config->service_code)){
                    $limits = [
                        'min_limit' => $config->min_limit,
                        'max_limit' => $config->max_limit,
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }
            }
        }
        else {
            throw new \Exception("Both API & database are not configured.");
        }
    }

    /**
     * @return mixed
     */
    public function getMarketCode()
    {
        return $this->marketCode;
    }

    /**
     * @param mixed $marketCode
     */
    public function setMarketCode($marketCode)
    {
        $this->marketCode = $marketCode;
    }


}
