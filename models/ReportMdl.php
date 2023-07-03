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

    public function getReportsByTargetId($type, $target_id) {
        // 0: post, 1: comment, 2: user's posts, 3: user's comments, 4: user's posts and comments

        if ($type == 0) {
            $sql = "SELECT * FROM report WHERE post_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $target_id);
        } else if ($type == 1) {
            $sql = "SELECT * FROM report WHERE comment_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $target_id);
        } else if ($type == 2) {
            // reports of posts of a user
            // join with "post" table to get the "author" of the post
            $sql = "SELECT report.post_id FROM report JOIN post ON report.post_id = post.id WHERE post.author = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $target_id);
        } else if ($type == 3) {
            // reports of comments of a user
            // join with "comment" table to get the "author" of the comment
            $sql = "SELECT report.comment_id FROM report JOIN comment ON report.comment_id = comment.id WHERE comment.author = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $target_id);
        } else if ($type == 4) {
            // reports of both posts and comments of a user
            // join with "post" and "comment" table to get the "author" of the post/comment
            $sql = "SELECT report.post_id FROM report JOIN post ON report.post_id = post.id WHERE post.author = ? UNION SELECT report.comment_id FROM report JOIN comment ON report.comment_id = comment.id WHERE comment.author = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $target_id, $target_id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function countReportsByTargetId($type, $target_id) {
        $result = $this->getReportsByTargetId($type, $target_id);

        return $result->num_rows;
    }
}
