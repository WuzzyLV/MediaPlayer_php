<?php

namespace Wuzzy\MusicPlayer\Database;

use Wuzzy\MusicPlayer\Database\Connection;

class Auth {
    protected $connection;

    public function __construct() {
        $database = new Connection();
        $this->connection = $database->getConnection();
    }

    private function getUser($username){
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

    public function login($username, $password) {
        $result = $this->getUser($username);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                return true;
            }
        }
        $_SESSION['loggedin'] = false;
            return false;
    }

    public function register($username, $password) {
        //Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $this->getUser($username);

        if ($result->num_rows > 0) {
            return false;
        }

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $this->connection->prepare($sql);

        if ($stmt == false) {
            echo "Error: " . $this->connection->error;
            return false;
        }
        $stmt->bind_param('ss', $username, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        return true;
    }
}