<?php

namespace App\Services;

use Doctrine\DBAL\Connection;

class Database
{
    private static ?Connection $connection = null;

    public static function getConnection(): ?Connection
    {
        if(self::$connection == null) {
            $connectionParams = [
                'dbname' => 'stock-api',
                'user' => 'root',
                'password' => $_ENV['MYSQL_PASSWORD'],
                'host' => $_ENV['MYSQL_HOST'],
                'driver' => 'pdo_mysql',
            ];

            self::$connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        }
        return self::$connection;
    }
}