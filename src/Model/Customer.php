<?php


namespace ZoodPay\Api\SDK\Model;


use JsonSerializable;

class Customer implements  JsonSerializable
{
private $customer_dob;
private $customer_email;
private $customer_phone;
private $customer_pid;
private $first_name;
private $last_name;

    /**
     * @return string
     */
    public function getCustomerDob()
    {
        return $this->customer_dob;
    }

    /**
     * @param string $customer_dob
     */
    public function setCustomerDob($customer_dob)
    {
        $this->customer_dob = $customer_dob;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    /**
     * @param string $customer_email
     */
    public function setCustomerEmail($customer_email)
    {
        $this->customer_email = $customer_email;
    }

    /**
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customer_phone;
    }

    /**
     * @param string $customer_phone
     */
    public function setCustomerPhone($customer_phone)
    {
        $this->customer_phone = $customer_phone;
    }

    /**
     * @return string
     */
    public function getCustomerPid()
    {
        return $this->customer_pid;
    }

    /**
     * @param string $customer_pid
     */
    public function setCustomerPid($customer_pid)
    {
        $this->customer_pid = $customer_pid;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string[]
     */
    public function jsonSerialize()
    {

        return  [
            "customer_dob"=>  $this->getCustomerDob(),
            "customer_email"=>  $this->getCustomerEmail(),
            "customer_phone"=> $this->getCustomerPhone() ,
            "customer_pid"=> $this->getCustomerPid(),
            "first_name"=> $this->getFirstName(),
            "last_name"=> $this->getLastName()

        ] ;


    }

}