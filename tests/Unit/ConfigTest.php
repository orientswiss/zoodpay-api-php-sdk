<?php

namespace ZoodPay\Api\SDK;

use PHPUnit\Framework\TestCase;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

class ConfigTest extends TestCase
{
    public function testGet()
    {

        $config = new  Config();
        $merchantKey = $config::get('merchant_id');
        $merchantSecretKey = $config::get('secret_key');
        $merchantSaltKey = $config::get('salt_key');
        $apiBaseUrl = $config::get('api_endpoint');
        $apiVersion = $config::get('api_version');
        $marketCode= $config::get('market_code');
        $dbHost = $config::get('db_host');
        $dbPort = $config::get('db_port');
        $dbDataBase = $config::get('db_database');
        $dbTable = $config::get('db_table_prefix');
        $dbUser = $config::get('db_user');
        $dbPassword = $config::get('db_password');
        $this->assertIsString($merchantKey);
        $this->assertIsString($merchantSecretKey);
        $this->assertIsString($merchantSaltKey);
        $this->assertIsString($apiBaseUrl);
        $this->assertIsString($apiVersion);
        $this->assertIsString($marketCode);
        $this->assertIsString($dbHost);
        $this->assertIsString($dbPort);
        $this->assertIsString($dbDataBase);
        $this->assertIsString($dbTable);
        $this->assertIsString($dbUser);
        $this->assertIsString($dbPassword);

    }

    public function testSet()
    {

        $config = new Config();
        $config::set('merchant_id', "Test1");
        $config::set('secret_key', "Test2");
        $config::set('salt_key', "Test3");
        $config::set('api_endpoint', "https://api.zoodpay.com/");
        $config::set('api_version', "v0");
        $config::set('market_code', "Test12");
        $config::set('db_host', "Test6");
        $config::set('db_port', "Test7");
        $config::set('db_database', "Test8");
        $config::set('db_table_prefix', "Test9");
        $config::set('db_user', "Test10");
        $config::set('db_password', "Test11");
        $merchantKey = $config::get('merchant_id');
        $merchantSecretKey = $config::get('secret_key');
        $merchantSaltKey = $config::get('salt_key');
        $apiBaseUrl = $config::get('api_endpoint');
        $apiVersion = $config::get('api_version');
        $dbHost = $config::get('db_host');
        $dbPort = $config::get('db_port');
        $dbDataBase = $config::get('db_database');
        $dbTable = $config::get('db_table_prefix');
        $dbUser = $config::get('db_user');
        $dbPassword = $config::get('db_password');
        $this->assertIsString($merchantKey);
        $this->assertIsString($merchantSecretKey);
        $this->assertIsString($merchantSaltKey);
        $this->assertIsString($apiBaseUrl);
        $this->assertIsString($apiVersion);
        $this->assertIsString($dbHost);
        $this->assertIsString($dbPort);
        $this->assertIsString($dbDataBase);
        $this->assertIsString($dbTable);
        $this->assertIsString($dbUser);
        $this->assertIsString($dbPassword);
    }


}
