<?php

namespace Wuzzy\MusicPlayer\Database;

class Connection {    
    protected $connection;

    public function __construct() {
        $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
