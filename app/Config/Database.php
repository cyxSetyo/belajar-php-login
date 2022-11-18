<?php

namespace Project\PHP\Login\Config;

use PDO;

class Database
{
    private static ?\PDO $pdo =null;

    private static function getConnection(): \PDO
    {
        if(self::$pdo == null)
        {
            //create PDO
        }else{
            return self::$pdo;
        }
    }
}

