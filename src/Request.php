<?php

namespace ZoodPay\Api\SDK;

use GuzzleHttp\Client;
use ZoodPay\Api\SDK\Http;

class Request extends Http
{
    protected $merchant;
    protected $headers = [
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json, */*'
    ];

    protected $data;

    /**
     * Class constructor
     */
    public function __construct($data = [], $merchant = null)
    {
        parent::__construct();

        if(!empty($merchant) && $merchant instanceof Merchant){
            $this->merchant = $merchant;
        }
        else{
            $this->merchant = $this->getMerchant();
        }

        if( ! empty($data)){
            $this->data = $data;
        }

    }

    /**
     * @return \ZoodPay\Api\SDK\Merchant
     */
    private function getMerchant()
    {
        if ($this->merchant instanceof Merchant) {
            # First, look for a Merchant instance as a property of this individual object.
            # This allows multiple Requests to be instantiated simultaneously,
            # each using different credentials.

            return $this->merchant;
        } else {
            # Otherwise, look for credentials as static properties of the parent class.
            # This allows credentials to be set once on the class, then used by
            # many different Requests.

            # If nothing is set on the class yet, as a last resort, try to
            # find credentials in the .env.php configuration file.

            $merchant = new Merchant();

            if (is_null(self::getMerchantId())) {
                self::setMerchantId(Config::get('merchant_id'));
            }

            if (is_null(self::getSecretKey())) {
                self::setSecretKey(Config::get('secret_key'));
            }
            if (is_null(self::getSaltKey())) {
                self::setSaltKey(Config::get('salt_key'));
            }
            if (is_null(self::getMarketCode())) {
                self::setMarketCode(Config::get('market_code'));
            }


            if (is_null(self::getApiEndPoint())) {
                self::setApiEndPoint(Config::get('api_endpoint'));
            }

            if (is_null(self::getApiVersion())) {
                self::setApiVersion(Config::get('api_version'));
            }

            $merchant->setMerchantId(self::getMerchantId())
                ->setSecretKey(self::getSecretKey())
                ->setApiEndPoint(self::getApiEndPoint())
                ->setApiVersion(self::getApiVersion())
               ->setSaltKey(self::getSaltKey());
            return $merchant;
        }
    }

    /**
     * Add new header to header array.
     * 
     * @param string    $header
     * @param string    $value
     * @return ZoodPay\Api\SDK\Request
     */
    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set Auth Header
     */
    protected function setAuthHeader()
    {
        $this->setHeader('Authorization', 'Basic ' . base64_encode($this->merchant->getMerchantId(). ':'. $this->merchant->getSecretKey()));
    }

    protected function setApplicationHeader(){
        $this->setHeader( 'Content-Type' , 'application/json');
    }

    /**
     * Set user agent info to parent class
     */
    protected function configureUserAgent()
    {
        $platformDetail = Http::getPlatformDetailsAsString();
        $composerJson   = Config::get('composer_json');

        $userAgent  =    [
            'zoodpay-sdk-php'   => $composerJson->version,
            'cURL'              => self::_isCurl() ? curl_version()['version'] : 'Disabled',
            'Merchant'          => $this->merchant->getMerchantId()
        ];
        
        $return     =   '';

        foreach($userAgent as $key => $value){
            $return .= "{$key}/{$value}; ";
        }

        if(empty($platformDetail)){
            $this->setHeader('User-Agent', $return);
        }
        else{
            $this->setHeader('User-Agent', $return . '(' . $platformDetail . ')');
        }
    }

    /**
     * Check whether curl is installed or not.
     */
    public function _isCurl(){
        return function_exists('curl_version');
    }

    /**
     * Create GuzzleHttp Client object. 
     * 
     * Note: Since Guzzle6, this object is immutable. We're setting base_uri & headers in this. 
     * Make sure you set all required headers using "setHeader" for a request before calling this function.
     * 
     * @return GuzzleHttp\Client
     */
    public function getClient()
    {
        $this->configureUserAgent();

        return new Client([ 
            'base_uri' => $this->merchant->getApiEndPoint(), 
            'headers' => $this->getHeaders()
        ]);
    }
}
