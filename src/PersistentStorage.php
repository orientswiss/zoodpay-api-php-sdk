<?php

namespace ZoodPay\Api\SDK;

use ZoodPay\Api\SDK\Config;
use ZoodPay\Api\SDK\Merchant;
use ZoodPay\Api\SDK\Exception\InvalidArgumentException;
use ZoodPay\Api\SDK\Requests\GetConfiguration;

final class PersistentStorage
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function disconnect()
    {
        self::$instance = null;
    }

    public static function testConnection()
    {
        $instance = self::getInstance();
        
        if ($instance->db_connection instanceof \mysqli) {
            $instance = null;
            self::disconnect();

            return true;
        }

        return false;
    }

    /**
     * Checks whether PersistentStorage is configured or not.
     */
    public static function isConfigured()
    {
        try{
            $instance = self::getInstance();
            return $instance->db_connection instanceof \mysqli;
        }
        catch(\Exception $e){
            return false;
        }
    }

    /**
     * Return limits for a given market and service
     * 
     * @param string    $marketCode
     * @param string    $service
     * @return array
     */
    public function getLimits($marketCode, $service)
    {
        $marketCode = strtoupper($marketCode);
        $service = strtoupper($service);

        if(!in_array($service, Merchant::SERVICES)){
            throw new InvalidArgumentException("Unexpected value '{$service}' for 'service' given; expected one of '" . implode("', '", Merchant::SERVICES) . "' (case insensitive)");
        }

        $instance = self::getInstance();
        list($need_to_get_fresh_data, $limits)   = $instance->getLimitFromDB($marketCode, $service);
        
        if($need_to_get_fresh_data){
            $limits = $instance->getLimitFromApi($marketCode, $service);
        }

        return $limits;
    }

    private $db_host;
    private $db_database;
    private $db_tablePrefix;
    private $db_user;
    private $db_password;
    private $db_connection;
    private $db_table = 'merchant_config';
    private $lifespan = 900;

    public function __construct()
    {
        $this->db_host = Config::get('db_host');
        $this->db_port = Config::get('db_port');
        $this->db_database = Config::get('db_database');
        $this->db_tablePrefix = Config::get('db_table_prefix');
        $this->db_user = Config::get('db_user');
        $this->db_password = Config::get('db_password');

        if (extension_loaded('mysqli')) {
            if (empty($this->db_host)) {
                $this->db_host = ini_get('mysqli.default_host');
            }

            if (empty($this->db_user)) {
                $this->db_user = ini_get('mysqli.default_user');
            }

            if (empty($this->db_password)) {
                $this->db_password = ini_get('mysqli.default_pw');
            }

            if (empty($this->db_port)) {
                $this->db_port = ini_get('mysqli.default_port');
            }

            # It's safe to suppress any errors/warnings/notices here because
            # if we can't connect we'll throw an Exception anyway.
            set_error_handler(function () {
            });
            $this->db_connection = new \mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_database, $this->db_port);
            // $this->db_connection->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, TRUE);
            restore_error_handler();

            if ($this->db_connection->connect_errno) {
                throw new \Exception($this->db_connection->connect_error, $this->db_connection->connect_errno);
            }
        } else {
            throw new \Exception("Required extension 'mysqli' not loaded");
        }
    }

    public function __destruct()
    {
        if (! is_null($this->db_connection)) {
            $this->db_connection->close();
            $this->db_connection = null;
        }
    }

    private static function inArrayCaseInsensitive($needle, $haystack, $strict = false)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack), $strict);
    }

    /**
     * Create the Merchant Config table
     */
    private function createConfigTable($marketCode, $service)
    {
        $table_name = preg_replace('/[^a-z0-9_]+/i', '', $this->db_tablePrefix . $this->db_table);
        $escaped_table_name = $this->db_connection->real_escape_string($table_name);
        
        /**
         * Create the missing table.
         * Note that this will use the default engine, charset and collation for the db.
         */
        $create_table_stmt = $this->db_connection->prepare("
            CREATE TABLE `{$escaped_table_name}` (
                `market_code` VARCHAR(3),
                `service_code` ENUM('ZPI', 'PAD'),
                `service_name` VARCHAR(100) DEFAULT NULL,
                `description` longtext DEFAULT NULL,
                `min_limit` DECIMAL(15,2) DEFAULT '0.00',
                `max_limit` DECIMAL(15,2) DEFAULT '0.00',
                `instalments` TINYINT(3) NULL,
                `created_at` DATETIME NULL,
                `updated_at` DATETIME NULL,
                PRIMARY KEY (`market_code`, `service_code`)
            )
        ");
        
        if ($create_table_stmt === false) {
            throw new Exception($this->db_connection->error, $this->db_connection->errno);
        } else {
            if(!$create_table_stmt->execute()){
                throw new Exception($this->db_connection->error, $this->db_connection->errno);
            }
            $create_table_stmt->close();
        }
    }

    /**
     * Return limits for a given market and service
     * 
     * @param string    $marketCode
     * @param string    $service
     * @return array    [$need_to_get_fresh_data, $limits]
     */
    private function getLimitFromDB($marketCode, $service)
    {
        $need_to_get_fresh_data = false;
        $table_name = preg_replace('/[^a-z0-9_]+/i', '', $this->db_tablePrefix . $this->db_table);
        $escaped_table_name = $this->db_connection->real_escape_string($table_name);
        
        $stmt = $this->db_connection->prepare("
                        SELECT `min_limit`, `max_limit`, `updated_at`
                        FROM `{$escaped_table_name}`
                        WHERE `market_code` = ? AND `service_code` = ?
                        LIMIT 1
                    ");
        
        if($stmt === false){
            if ($this->db_connection->errno == 1146) {
                $this->createConfigTable($marketCode,$service);
                return [true, null];
            } else {
                throw new \Exception($this->db_connection->error, $this->db_connection->errno);
            }
        }
        else{
            $stmt->bind_param('ss', $marketCode, $service);
            $stmt->execute();
            $result = $stmt->get_result();
            $limits = $result->fetch_assoc();
            $stmt->close();
            $result->free();
            
            if (empty($limits) || time() - strtotime($limits['updated_at']) > $this->lifespan) {
                $need_to_get_fresh_data = true;
            }
            else{
                // If mysqlnd has MYSQLI_OPT_INT_AND_FLOAT_NATIVE = true then int & float would be 
                // return as native datatype otherwise in string, so convert them back to float;
                $limits['min_limit']    = (float) $limits['min_limit'];
                $limits['max_limit']    = (float) $limits['max_limit'];
            }

            return [$need_to_get_fresh_data, $limits];
        }
    }

    /**
     * Return limits for a given market and service either by fetching from db or APi call
     * 
     * @param string    $marketCode
     * @param string    $service
     * @return array
     */
    private function getLimitFromApi($marketCode, $service)
    {
        // Fetch data from API 
        $request = new GetConfiguration(['market_code' => $marketCode]);
        $response = $request->get();
        
        $configuration = json_decode($response->getBody()->getContents())->configuration;
        
        $now = date('Y-m-d H:i:s');
        $table_name = preg_replace('/[^a-z0-9_]+/i', '', $this->db_tablePrefix . $this->db_table);
        $escaped_table_name = $this->db_connection->real_escape_string($table_name);

        // var_dump($configuration);die;
        foreach($configuration as $config)
        {
            $stmt = $this->db_connection->prepare("
                INSERT INTO `{$escaped_table_name}` (
                    `market_code`,
                    `service_code`,
                    `service_name`,
                    `description`,
                    `min_limit`,
                    `max_limit`,
                    `instalments`,
                    `created_at`,
                    `updated_at`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    `service_name` = ?,
                    `description` = ?,
                    `min_limit` = ?,
                    `max_limit` = ?,
                    `instalments` = ?,
                    `updated_at` = ?
            ");

            if (!$stmt) {
                throw new \Exception($this->db_connection->error, $this->db_connection->errno);
            }
            
            $stmt->bind_param(
                "sssssssssssssss",
                $marketCode,
                $config->service_code,
                $config->service_name,
                $config->description,
                $config->min_limit,
                $config->max_limit,
                $config->instalments,
                $now,
                $now,
                $config->service_name,
                $config->description,
                $config->min_limit,
                $config->max_limit,
                $config->instalments,
                $now
            );

            if(!$stmt->execute()){
                throw new \Exception($this->db_connection->error, $this->db_connection->errno);
            }
            $stmt->close();

            if(strtolower($service) == strtolower($config->service_code)){
                $limits = [
                    'min_limit' => $config->min_limit,
                    'max_limit' => $config->max_limit,
                    'updated_at'=> $now
                ];
            }
        }

        return $limits;
    }
}