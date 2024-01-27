<?php

namespace Wuzzy\MusicPlayer\Database;
use Wuzzy\MusicPlayer\Database\Connection;

class User {    
    protected $connection;

    public function __construct() {
        $database = new Connection();
        $this->connection = $database->getConnection();
    }

    public function getUser($username){
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->connection->prepare($sql);

        if ($stmt == false) {
            echo "Error: " . $this->connection->error;
            die();
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getIDByUsername($username){
        $result = $this->getUser($username);

        return $result->fetch_assoc()['id'];
    }
}