<?php

class Voting {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addVote($post_id, $comment_id, $voter, $is_upvote) {
        $column_name = $comment_id == NULL ? "post_id" : "comment_id";
        $bind_value = $comment_id == NULL ? $post_id : $comment_id;

        // check if vote already existed. if true, delete only. if false, delete and insert
        $existed = $this->voteExisted($post_id, $comment_id, $voter, $is_upvote);

        // delete all existing votes with the same post_id, comment_id, and voter
        $sql_delete = "DELETE FROM voting WHERE " . $column_name . " = ? AND voter = ?";
        $stmt_delete = $this->conn->prepare($sql_delete);
        $stmt_delete->bind_param("is", $bind_value, $voter);
        $stmt_delete->execute();
        $stmt_delete->close();

        if ($existed) {
            return;
        }

        // insert new vote
        $sql_insert = "INSERT INTO voting (" . $column_name . ", voter, is_upvote) VALUES (?, ?, ?)";
        $stmt_insert = $this->conn->prepare($sql_insert);
        $stmt_insert->bind_param("isi", $bind_value, $voter, $is_upvote);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    public function voteExisted($post_id, $comment_id, $voter, $is_upvote) {
        $column_name = $comment_id == NULL ? "post_id" : "comment_id";
        $bind_value = $comment_id == NULL ? $post_id : $comment_id;

        $sql = "SELECT * FROM voting WHERE " . $column_name . " = ? AND voter = ? AND is_upvote = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $bind_value, $voter, $is_upvote);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    public function votingScore($post_id, $comment_id) {
        $column_name = $comment_id == NULL ? "post_id" : "comment_id";
        $bind_value = $comment_id == NULL ? $post_id : $comment_id;

        $sql_upvotes = "SELECT COUNT(*) AS upvotes FROM voting WHERE " . $column_name . " = ? AND is_upvote = 1";
        $stmt_upvotes = $this->conn->prepare($sql_upvotes);
        $stmt_upvotes->bind_param("i", $bind_value);
        $stmt_upvotes->execute();
        $result_upvotes = $stmt_upvotes->get_result();
        $upvotes = $result_upvotes->fetch_assoc()["upvotes"];
        $stmt_upvotes->close();

        $sql_downvotes = "SELECT COUNT(*) AS downvotes FROM voting WHERE " . $column_name . " = ? AND is_upvote = 0";
        $stmt_downvotes = $this->conn->prepare($sql_downvotes);
        $stmt_downvotes->bind_param("i", $bind_value);
        $stmt_downvotes->execute();
        $result_downvotes = $stmt_downvotes->get_result();
        $downvotes = $result_downvotes->fetch_assoc()["downvotes"];
        $stmt_downvotes->close();

        return $upvotes - $downvotes;
    }
}
