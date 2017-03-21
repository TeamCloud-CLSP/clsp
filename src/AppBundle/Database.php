<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\DriverManager;

class Database {
    private static $instance;
    private $conn;

    public function __construct($db_host, $db_port, $db_name, $db_user, $db_pw) {
        $this->conn = DriverManager::getConnection(array(
            'dbname'    => $db_name,
            'user'      => $db_user,
            'password'  => $db_pw,
            'host'      => $db_host,
            'driver'    => 'pdo_mysql',
        ));
    }

    public function getConn() {
        return $this->conn;
    }
}
