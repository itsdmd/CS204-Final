<?php

class Report {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addReport($post_id, $comment_id, $reporter, $reason) {
        if ($this->reportExisted($post_id, $comment_id, $reporter)) {
            return;
        }

        if ($post_id == NULL) {
            $sql = "INSERT INTO report (comment_id, reporter, reason) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $comment_id, $reporter, $reason);
        } else if ($comment_id == NULL) {
            $sql = "INSERT INTO report (post_id, reporter, reason) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $post_id, $reporter, $reason);
        } else {
            $sql = "INSERT INTO report (post_id, comment_id, reporter, reason) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiss", $post_id, $comment_id, $reporter, $reason);
        }

        $stmt->execute();
        $stmt->close();
    }

    public function deleteReport($post_id, $comment_id, $reporter) {
        if ($post_id == NULL) {
            $sql = "DELETE FROM report WHERE comment_id = ? AND reporter = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $comment_id, $reporter);
        } else if ($comment_id == NULL) {
            $sql = "DELETE FROM report WHERE post_id = ? AND reporter = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $post_id, $reporter);
        } else {
            $sql = "DELETE FROM report WHERE post_id = ? AND comment_id = ? AND reporter = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iis", $post_id, $comment_id, $reporter);
        }

        $stmt->execute();
        $stmt->close();
    }

    public function reportExisted($post_id, $comment_id, $reporter) {
        if ($post_id == NULL) {
            $sql = "SELECT * FROM report WHERE comment_id = ? AND reporter = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $comment_id, $reporter);
        } else if ($comment_id == NULL) {
            $sql = "SELECT * FROM report WHERE post_id = ? AND reporter = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $post_id, $reporter);
        } else {
            $sql = "SELECT * FROM report WHERE post_id = ? AND comment_id = ? AND reporter = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iis", $post_id, $comment_id, $reporter);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    public function countReportsByTargetId($type, $target_id) {
        if ($type == 0) {
            $sql = "SELECT * FROM report WHERE post_id = ?";
        } else {
            $sql = "SELECT * FROM report WHERE comment_id = ?";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $target_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows;
    }
}
