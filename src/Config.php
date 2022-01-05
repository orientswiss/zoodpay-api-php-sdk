<?php

namespace ZoodPay\Api\SDK;

use ZoodPay\Api\SDK\Exception\InvalidArgumentException;
use ZoodPay\Api\SDK\Exception\ParsingException;

final class Config
{
    /**
     * @var array $data
     */
    private static $data = [
        /**
         * These are properties of a merchant account.
         */
        'merchant_id' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'secret_key' => [
            'type' => 'string',
            'src' => '.env.php'
        ],

        'salt_key' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'api_endpoint' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'api_version' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'market_code' => [
            'type' => 'string',
            'src' => '.env.php'
        ],

        /**
         * These are database settings.
         */
        'db_host' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'db_port' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'db_database' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'db_table_prefix' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'db_user' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        'db_password' => [
            'type' => 'string',
            'src' => '.env.php'
        ],
        /**
         * This is where the contents of the SDK's composer.json file will be loaded.
         */
        'composer_json' => [
            'type' => 'object',
            'src' => 'composer.json'
        ]
    ];

    /**
     * @var bool $envConfigLoaded
     */
    private static $envConfigLoaded = false;

    /**
     * @var bool $composerJsonLoaded
     */
    private static $composerJsonLoaded = false;

    /**
     * Multi-level dirname support for PHP 5.6.
     * (The $levels argument was introduced in PHP 7.0.)
     *
     * @param string $path
     * @param int $levels
     * @return string
     */
    private static function dirname($path, $levels = 1)
    {
        if ($levels > 1) {
            return dirname(self::dirname($path, --$levels));
        } else {
            return dirname($path);
        }
    }

    /**
     * @param mixed $needle
     * @param array $haystack
     * @param bool $strict
     * @return bool
     * @see https://www.php.net/manual/en/function.in-array.php#89256
     */
    private static function inArrayCaseInsensitive($needle, $haystack, $strict = false)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack), $strict);
    }

    /**
     * @throws ZoodPay\Api\SDK\Exception\ParsingException
     */
    private static function loadEnvConfig()
    {
        $zoodpay_sdk_env_config = null;
        $package_installation_path = self::dirname(__FILE__, 2);
        $env_php_path = "{$package_installation_path}/.env.php";

        if (file_exists($env_php_path)) {
            include $env_php_path;

            if (is_array($zoodpay_sdk_env_config)) {
                foreach ($zoodpay_sdk_env_config as $property => $value) {
                    if (array_key_exists($property, self::$data)) {
                        self::set($property, $value);
                    } else {
                        throw new ParsingException("Unexpected property '{$property}' found in '.env.php' configuration file");
                    }
                }
            } else {
                throw new ParsingException('Failed to parse \'.env.php\' configuration file');
            }
        } else {
            foreach (self::$data as $property => $data) {
                if ($data[ 'src' ] == '.env.php') {
                    $value = getenv(strtoupper($property));

                    if ($value !== false) {
                        self::set($property, $value);
                    }
                }
            }
        }

        self::$envConfigLoaded = true;
    }

    /**
     * @throws ZoodPay\Api\SDK\Exception\ParsingException
     */
    private static function loadComposerJson()
    {
        $package_installation_path = self::dirname(__FILE__, 2);
        $composer_json_path = "{$package_installation_path}/composer.json";

        if (file_exists($composer_json_path)) {
            $composerJson = json_decode(file_get_contents($composer_json_path));

            if (is_null($composerJson)) {
                throw new ParsingException(json_last_error_msg(), json_last_error());
            }

            self::set('composer_json', $composerJson);
        } else {
            throw new ParsingException('Unable to locate \'composer.json\' configuration file');
        }

        self::$composerJsonLoaded = true;
    }

    /**
     * @param string $property
     * @param mixed $value
     * @throws ZoodPay\Api\SDK\Exception\InvalidArgumentException
     */
    public static function set($property, $value)
    {
        if (! is_string($property)) {
            throw new InvalidArgumentException('Expected string for $property; ' . gettype($property) . ' given');
        }

        if (! array_key_exists($property, self::$data)) {
            throw new InvalidArgumentException("Invalid string given for \$property: '{$property}'");
        }

        if (self::$data[ $property ][ 'type' ] == 'enum') {
            if (! in_array($value, self::$data[ $property ][ 'options' ])) {
                throw new InvalidArgumentException("Unexpected value '{$value}' for '{$property}' given; expected one of '" . implode("', '", self::$data[ $property ][ 'options' ]) . "'");
            }
        } elseif (self::$data[ $property ][ 'type' ] == 'enumi') {
            if (! self::inArrayCaseInsensitive($value, self::$data[ $property ][ 'options' ])) {
                throw new InvalidArgumentException("Unexpected value '{$value}' for '{$property}' given; expected one of '" . implode("', '", self::$data[ $property ][ 'options' ]) . "' (case insensitive)");
            }
        } else {
            if (gettype($value) != self::$data[ $property ][ 'type' ]) {
                throw new InvalidArgumentException('Expected ' . self::$data[ $property ][ 'type' ] . " for \$value of '{$property}'; " . gettype($value) . ' given');
            }
        }

        self::$data[ $property ][ 'value' ] = $value;
    }

    /**
     * @param string $property
     * @return mixed
     */
    public static function get($property)
    {
        if (array_key_exists($property, self::$data)) {
            if (self::$data[$property]['src'] == '.env.php') {
                if (! self::$envConfigLoaded) {
                    self::loadEnvConfig();
                }
            } 
            elseif (self::$data[$property]['src'] == 'composer.json') {
                if (! self::$composerJsonLoaded) {
                    self::loadComposerJson();
                }
            }

            if (array_key_exists('value', self::$data[$property])) {
                return self::$data[$property]['value'];
            } elseif (array_key_exists('default', self::$data[$property])) {
                return self::$data[$property]['default'];
            }
        }

        return null;
    }
}
