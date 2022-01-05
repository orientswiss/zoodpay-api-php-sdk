<?php
// Create .env.php file by copying this config array and change values accordingly.
$zoodpay_sdk_env_config = [
    'merchant_id'   => 'test', // From The Credentials that you received from ZoodPay
    'secret_key'    => 'secret', // From The Credentials that you received from ZoodPay
    'salt_key'    => 'salt', // From The Credentials that you received from ZoodPay
    'api_endpoint'  => 'https://api.zoodpay.com/', // Refer API Environments section from https://apidocs.zoodpay.com/
    'api_version'   => 'v0', // Refer API Environments section from https://apidocs.zoodpay.com/
    'market_code' => "", // The ISO 3166-1 country code. Length should be 2 or 3 characters. Possible values are "KZ", "UZ", "IQ", "JO", "KSA", "KW", "LB"
    'db_host'       => '127.0.0.1',
    'db_port'       => '3306',
    'db_database'   => 'merchant',
    'db_table_prefix'=> 'zoodpay_',
    'db_user'       => 'root',
    'db_password'   => 'root'
];