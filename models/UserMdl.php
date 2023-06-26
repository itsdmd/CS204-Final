<?php

class User {
    public $errors = [];
    public $user = [];

    public $username;
    public $password;
    public $role;
    public $avatar_id;

    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function userExists() {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!empty($result)) {
            $this->password = $result["password"];
            $this->role = $result["role"];
            // var_dump($this);
            return true;
        } else {
            return false;
        }
    }

    public function createNewUser() {
        $sql = "INSERT INTO user (username, password, role, avatar_id, date_created) VALUES (?, ?, ?, NULL, DEFAULT)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $this->username, $this->password, $this->role);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            header("Location: " . ROOT);
        }

        $stmt->close();
    }

    public function initAdmin() {
        $sql = "SELECT * FROM user WHERE username = 'admin'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            $this->username = "admin";
            $this->password = password_hash("superuser", PASSWORD_DEFAULT);
            $this->role = "0";
            $this->createNewUser();
        }
    }

    public function getUserAvatarId($username) {
        $this->username = $username;
        if (!$this->userExists()) {
            return false;
        }

        $sql = "SELECT avatar_id FROM user WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result["avatar_id"];
    }

    public function getUserAvatarPath($username) {
        $this->username = $username;
        if (!$this->userExists()) {
            return false;
        }

        $sql = "SELECT path FROM media WHERE id = (SELECT avatar_id FROM user WHERE username = ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result["path"];
    }

    public function setUserAvatar($file_id) {
        $sql = "UPDATE user SET avatar_id = ? WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $file_id, $this->username);
        $stmt->execute();
        $stmt->close();
    }
}
