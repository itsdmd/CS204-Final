<?php

class Deleted {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteItem($type, $id, $deleted_by) {
        $sql = "INSERT INTO deleted (type, target_id, deleted_by) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $type, $id, $deleted_by);
        $stmt->execute();
    }

    public function itemIsDeleted($type, $id) {
        $sql = "SELECT * FROM deleted WHERE type = ? AND target_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $type, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
