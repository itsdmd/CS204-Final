<?php

class Comment {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAllCommentsByTargetId($type, $id) {
        // $type: 0: post, 1: comment
        $sql = "SELECT * FROM comment WHERE reply_to = ? AND type = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $id, $type);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createComment($author, $type, $reply_to, $body) {
        $sql = "INSERT INTO comments (author, type, reply_to, body) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam("ssss", $author, $type, $reply_to, $body);
        $stmt->execute();
    }
}
