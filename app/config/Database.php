<?php
namespace App\Config;

use mysqli;

class Database {
    private static ?Database $instance = null;
    private ?mysqli $connection = null;

    private function __construct() {
        $this->connection = new mysqli('localhost', 'root', '', 'event_management_db');

        if ($this->connection->connect_error) {
            die("Помилка підключення до бази даних: " . $this->connection->connect_error);
        }
        $this->connection->set_charset("utf8mb4");
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }
}