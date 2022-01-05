<?php


namespace ZoodPay\Api\SDK\Model;


use JsonSerializable;

class Order implements JsonSerializable
{

    private $amount;
    private $currency;
    private $discount_amount;
    private $lang;
    private $market_code;
    private $merchant_reference_no;
    private $service_code;
    private $shipping_amount;
    private $signature;
    private $tax_amount;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getDiscountAmount()
    {
        return $this->discount_amount;
    }

    /**
     * @param int $discount_amount
     */
    public function setDiscountAmount($discount_amount)
    {
        $this->discount_amount = $discount_amount;
    }

    /**
     * @return string lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getMarketCode()
    {
        return $this->market_code;
    }

    /**
     * @param string $market_code
     */
    public function setMarketCode($market_code)
    {
        $this->market_code = $market_code;
    }

    /**
     * @return string
     */
    public function getMerchantReferenceNo()
    {
        return $this->merchant_reference_no;
    }

    /**
     * @param string $merchant_reference_no
     */
    public function setMerchantReferenceNo($merchant_reference_no)
    {
        $this->merchant_reference_no = $merchant_reference_no;
    }

    /**
     * @return string
     */
    public function getServiceCode()
    {
        return $this->service_code;
    }

    /**
     * @param string $service_code
     */
    public function setServiceCode($service_code)
    {
        $this->service_code = $service_code;
    }

    /**
     * @return int
     */
    public function getShippingAmount()
    {
        return $this->shipping_amount;
    }

    /**
     * @param int $shipping_amount
     */
    public function setShippingAmount($shipping_amount)
    {
        $this->shipping_amount = $shipping_amount;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return int
     */
    public function getTaxAmount()
    {
        return $this->tax_amount;
    }

    /**
     * @param int $tax_amount
     */
    public function setTaxAmount($tax_amount)
    {
        $this->tax_amount = $tax_amount;
    }


    /**
     * @return mixed
     */
    public function jsonSerialize()
    {

       return  [
           "amount"=> $this->getAmount(),
    "currency"=> $this->getCurrency(),
    "discount_amount"=> $this->getDiscountAmount(),
    "lang"=> $this->getLang(),
    "market_code"=> $this->getMarketCode(),
    "merchant_reference_no"=>$this->getMerchantReferenceNo(),
    "service_code"=> $this->getServiceCode(),
    "shipping_amount"=> $this->getShippingAmount(),
    "signature"=> $this->getSignature(),
    "tax_amount"=> $this->getTaxAmount()
       ] ;

    }
}