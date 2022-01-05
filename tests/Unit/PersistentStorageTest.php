<?php

namespace ZoodPay\Api\SDK;

use PHPUnit\Framework\TestCase;

class PersistentStorageTest extends TestCase
{
    /**
     * @throws Exception\InvalidArgumentException
     */
    public function testTestConnection()
    {

        $this->assertEquals(true, PersistentStorage::testConnection(), "Connection To MySQL Is Not Established");

        if (PersistentStorage::testConnection()) {
            $limits = (new PersistentStorage)->getLimits('UZ', 'ZPI');
            $this->assertArrayHasKey("min_limit", $limits, "Min Limit Not Available");
            $this->assertArrayHasKey("max_limit", $limits, "Max Limit Not Available");
            $this->assertArrayHasKey("updated_at", $limits, "Updated At Not Available");
        }


    }

}
