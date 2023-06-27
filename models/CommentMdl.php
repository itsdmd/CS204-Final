<?php

class Comment {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchCommentById($comment_id) {
        $sql = "SELECT * FROM comment WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result;
    }

    public function fetchAllCommentsByTargetId($type, $id) {
        // $type: 0: post, 1: comment
        $sql = "SELECT * FROM comment WHERE reply_to = ? AND type = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $id, $type);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(1, $results);
    }

    public function addComment($author, $type, $reply_to, $content) {
        $sql = "INSERT INTO comment (author, type, reply_to, content) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $author, $type, $reply_to, $content);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteComment($comment_id, $deleter) {
        $deleteCtrl = new DeletedCtrl();
        $deleteCtrl->deleteComment($comment_id, $deleter);
    }
}
