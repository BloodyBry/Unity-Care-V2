<?php

class Database {
    private $connection;

    public function __construct() {
        $config = require __DIR__ . '/../../config/database.php';

        $this->connection = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['database']
        );

        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
