<?php

namespace Project\PHP\Login\Config;

require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testGetConnection()
    {
        $connection = Database::getConnection();
        self::assertNotNull($connection);
    }

    public function testGetConnectionSingletone()
    {
        $connection1 = Database::getConnection(); 
        $connection2 = Database::getConnection();
        self::assertSame($connection1, $connection2);
    }
}