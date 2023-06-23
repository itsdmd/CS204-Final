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

    public function addComment($author, $type, $reply_to, $content) {
        $sql = "INSERT INTO comment (author, type, reply_to, content) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $author, $type, $reply_to, $content);
        $stmt->execute();
    }
}
