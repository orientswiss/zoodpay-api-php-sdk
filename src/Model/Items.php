<?php


namespace ZoodPay\Api\SDK\Model;


use JsonSerializable;

class Items implements JsonSerializable
{


    private $categories;
    private $currency_code;
    private $discount_amount;
    private $name;
    private $price;
    private $quantity;
    private $sku;
    private $tax_amount;



    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     */
    public function setCurrencyCode($currency_code)
    {
        $this->currency_code = $currency_code;
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
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return  [
            "categories"=>  [$this->getCategories()],
            "currency_code"=> $this->getCurrencyCode() ,
            "discount_amount"=>  $this->getDiscountAmount(),
            "name"=> $this->getName() ,
            "price"=>  $this->getPrice(),
            "quantity"=> $this->getQuantity() ,
            "sku"=> $this->getSku(),
            "tax_amount"=> $this->getTaxAmount()
            ];
    }
}