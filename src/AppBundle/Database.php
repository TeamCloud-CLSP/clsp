<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\DriverManager;

class Database {
    private static $instance;
    private $conn;

    private function __construct() {
        $this->conn = DriverManager::getConnection(array(
            'dbname' => 'symfony',
            'user' => 'root',
            'password' => null,
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ));
    }

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
