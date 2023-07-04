<?php

class Deleted {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function hideItem($type, $id, $deleted_by) {
        if ($type == 0) {
            $sql = "INSERT INTO deleted (post_id, deleted_by) VALUES (?, ?)";
        } else {
            $sql = "INSERT INTO deleted (comment_id, deleted_by) VALUES (?, ?)";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $id, $deleted_by);
        $stmt->execute();
    }

    public function deleteItem($table, $id) {
        $sql = "DELETE FROM " . $table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $table, $id);
        $stmt->execute();
    }

    public function itemIsHidden($type, $id) {
        if ($type == 0) {
            $sql = "SELECT * FROM deleted WHERE post_id = ?";
        } else {
            $sql = "SELECT * FROM deleted WHERE comment_id = ?";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
