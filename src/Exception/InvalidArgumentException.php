<?php

namespace ZoodPay\Api\SDK\Exception;

class InvalidArgumentException extends \Exception
{
    public function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
