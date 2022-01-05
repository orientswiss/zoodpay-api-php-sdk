<?php

namespace ZoodPay\Api\SDK;

use ZoodPay\Api\SDK\Exception\InvalidArgumentException;
use ZoodPay\Api\SDK\Exception\ParsingException;

class Http
{
    /**
     * @var string $merchantId
     */
    private static $merchantId;

    /**
     * @var string $secretKey
     */
    private static $secretKey;

    /**
     * @var string @saltKey
     */
    private static $saltKey;
    /**
     * @var string $apiEndPoint
     */
    private static $apiEndPoint;

    /**
     * @var string $apiVersion
     */
    private static $apiVersion;

    private static $marketCode;

    /**
     * @var array $userAgentPlatformDetails
     */
    private static $userAgentPlatformDetails = [];

    /**
     * @return string
     */
    public static function getMerchantId()
    {
        return self::$merchantId;
    }

    /**
     * @param string $merchantId
     */
    public static function setMerchantId($merchantId)
    {
        self::$merchantId = $merchantId;
    }

    /**
     * @return string
     */
    public static function getSecretKey()
    {
        return self::$secretKey;
    }

    /**
     * @param string $secretKey
     */
    public static function setSecretKey($secretKey)
    {
        self::$secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public static function getSaltKey()
    {
        return self::$saltKey;
    }

    /**
     * @param string $saltKey
     */
    public static function setSaltKey($saltKey)
    {
        self::$saltKey = $saltKey;
    }

    /**
     * @return string
     */
    public static function getApiEndPoint()
    {
        return self::$apiEndPoint;
    }

    /**
     * @param string $apiEndPoint
     */
    public static function setApiEndPoint($apiEndPoint)
    {
        self::$apiEndPoint = $apiEndPoint;
    }

    /**
     * @return string
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * Call this method to declare additional information about the platform where this SDK is being implemented.
     * This can expedite and improve ZoodPay's capacity to provide support, should the need arise.
     *
     * For example, consider the following two lines near the beginning of a script on a WooCommerce website:
     *
     *      Http::addPlatformDetail('WordPress', $wp_version);
     *      Http::addPlatformDetail('WooCommerce', WC()->version);
     *
     * As a result, API requests received by ZoodPay will contain a User-Agent header similar to the following:
     *
     *      Zoodpay-sdk-php/1.0.2 (WordPress/5.6; WooCommerce/4.9.2; PHP/7.3.11; cURL/7.64.1; Merchant/41599)
     *                              ++++++++++++++++++++++++++++++++++
     *
     * @param string $software
     * @param string $version
     */
    public static function addPlatformDetail($software, $version)
    {
        self::$userAgentPlatformDetails[$software] = $version;
    }

    /**
     * @return string
     */
    public static function getPlatformDetailsAsString()
    {
        $return = null;

        if (!empty(self::$userAgentPlatformDetails)) {
            foreach (self::$userAgentPlatformDetails as $software => $version) {
                $return .= "{$software}/{$version}; ";
            }
        }
        else $return .= "{No Platform}/{No Version}; ";

        return $return;
    }

    /**
     * Clear platform details.
     *
     * Note: This method only exists to prevent the static property values
     *       from persisting across unrelated integration tests.
     */
    public static function clearPlatformDetails()
    {
        self::$userAgentPlatformDetails = [];
    }
   
    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public static function getMarketCode()
    {
        return self::$marketCode;
    }

    /**
     * @param mixed $marketCode
     */
    public static function setMarketCode($marketCode)
    {
        self::$marketCode = $marketCode;
    }


}
