<?php


namespace Zoodpay\Api\SDK\Requests;


use ZoodPay\Api\SDK\Model\Order;
use ZoodPay\Api\SDK\Request;
use ZoodPay\Api\SDK\Exception\InvalidArgumentException;

class Signature extends Request
{
    /**
     * @param Order $order
     * @return Order
     * @throws InvalidArgumentException
     */
    public function CreateTransactionSignature(Order $order){

        $errorMessage = null;

        if ( ( is_null($order->getMerchantReferenceNo())) || ( is_null($order->getMarketCode())) ||  is_null($order->getAmount())  ||  is_null($order->getCurrency()) || is_null($this->merchant->getMerchantId()) || is_null($this->merchant->getSaltKey()))
        {
            if(is_null($order->getMerchantReferenceNo()))
            {
                $order->setSignature( $order->getSignature() .  "Merchant Reference Number is Null");
                $errorMessage  .= "Merchant Reference Number is Null";
            }
            if(is_null($order->getMarketCode()))
            {
                $order->setSignature( $order->getSignature() .  "Market Code is Null");
                $errorMessage  .= "Market Code is Null";

            }
            if( ( is_null($order->getAmount())) )
            {
                $order->setSignature( $order->getSignature() .  "Amount is Null");
                $errorMessage  .= "Amount is Null";
            }
            if( ( is_null($order->getCurrency())) )
            {
                $order->setSignature( $order->getSignature() .  "Currency is Null");
                $errorMessage  .= "Currency is Null";
            }
            if(is_null($this->merchant->getMerchantId())){
                $order->setSignature( $order->getSignature() .  "Merchant Key  is Null");
                $errorMessage  .= "Merchant Key  is Null";
            }
            if(is_null($this->merchant->getSaltKey())){
                $order->setSignature( $order->getSignature() .  "Merchant Salt Key  is Null");
                $errorMessage  .= "Merchant Salt Key  is Null";
            }
            if (! is_null($errorMessage)){
                throw new InvalidArgumentException('Error in Creating Signature due to: '  . $errorMessage);
            }
        }
        else {

            $order->setSignature(hash("sha512", implode("|", array($this->merchant->getMerchantId(), $order->getMerchantReferenceNo(), $order->getAmount(), $order->getCurrency(), $order->getMarketCode(), $this->merchant->getSaltKey()))));

        }
        return $order;
    }

    /**
     * @param $market_code
     * @param $currency
     * @param $amount
     * @param $merchant_reference_no
     * @param $transaction_id
     * @return false|string
     * @throws InvalidArgumentException
     */
    public function ZoodPayResponseSignature($market_code, $currency, $amount, $merchant_reference_no, $transaction_id){

        $errorMessage = null;

        if ( ( is_null($market_code)) || ( is_null($currency)) ||  is_null($amount)  ||  is_null($merchant_reference_no)||  is_null($transaction_id) || is_null($this->merchant->getMerchantId()) || is_null($this->merchant->getSaltKey()))
        {
            if(is_null($merchant_reference_no))
            {

                $errorMessage  .= "Merchant Reference Number is Null";
            }
            if(is_null($market_code))
            {

                $errorMessage  .= "Market Code is Null";

            }
            if(is_null($transaction_id))
            {

                $errorMessage  .= "Market Code is Null";

            }
            if( ( is_null($amount)) )
            {

                $errorMessage  .= "Amount is Null";
            }
            if( ( is_null($currency)) )
            {

                $errorMessage  .= "Currency is Null";
            }
            if(is_null($this->merchant->getMerchantId())){

                $errorMessage  .= "Merchant Key  is Null";
            }
            if(is_null($this->merchant->getSaltKey())){

                $errorMessage  .= "Merchant Salt Key  is Null";
            }
            if (! is_null($errorMessage)){
                throw new InvalidArgumentException('Error in Creating Signature due to: '  . $errorMessage);
            }
        }
        else {
            return (hash("sha512", implode("|", array($market_code, $currency, number_format((float)$amount, 2, '.', ''), $merchant_reference_no, $this->merchant->getMerchantId(),$transaction_id, $this->merchant->getSaltKey()))));
        }

    }

    /**
     * @param $merchant_refund_reference
     * @param $refund_amount
     * @param $status
     * @param $refund_id
     * @return false|string|void
     * @throws InvalidArgumentException
     */
    public function ZoodPayRefundResponseSignature($merchant_refund_reference, $refund_amount, $status, $refund_id){
        $errorMessage = null;

        if ( ( is_null($merchant_refund_reference)) || ( is_null($refund_amount)) ||  is_null($status)  ||  is_null($refund_id) || is_null($this->merchant->getMerchantId()) || is_null($this->merchant->getSaltKey()))
        {
            if(is_null($merchant_refund_reference))
            {

                $errorMessage  .= "Merchant Refund Number is Null";
            }
            if(is_null($refund_amount))
            {

                $errorMessage  .= "Refund Amount is Null";

            }
            if(is_null($status))
            {

                $errorMessage  .= "Status Code is Null";

            }
            if( ( is_null($refund_id)) )
            {

                $errorMessage  .= "Refund Id is Null";
            }

            if(is_null($this->merchant->getMerchantId())){

                $errorMessage  .= "Merchant Key  is Null";
            }
            if(is_null($this->merchant->getSaltKey())){

                $errorMessage  .= "Merchant Salt Key  is Null";
            }
            if (! is_null($errorMessage)){
                throw new InvalidArgumentException('Error in Creating Signature due to: '  . $errorMessage);
            }
        }
        else {
            return (hash("sha512", implode("|", array($merchant_refund_reference, number_format((float)$refund_amount, 2, '.', ''), $status, $this->merchant->getMerchantId(),$refund_id, $this->merchant->getSaltKey()))));


        }
    }
}