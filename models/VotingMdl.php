<?php

class Voting {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addVote($target_type, $target_id, $voter, $is_upvote) {
        // check if vote already existed. if true, delete only. if false, delete and insert
        $existed = $this->voteExisted($target_type, $target_id, $voter, $is_upvote);

        // delete all existing votes with the same target_type, target_id, and voter
        $sql_delete = "DELETE FROM voting WHERE target_type = ? AND target_id = ? AND voter = ?";
        $stmt_delete = $this->conn->prepare($sql_delete);
        $stmt_delete->bind_param("iis", $target_type, $target_id, $voter);
        $stmt_delete->execute();
        $stmt_delete->close();

        if ($existed) {
            return;
        }

        // insert new vote
        $sql_insert = "INSERT INTO voting (target_type, target_id, voter, is_upvote) VALUES (?, ?, ?, ?)";
        $stmt_insert = $this->conn->prepare($sql_insert);
        $stmt_insert->bind_param("iisi", $target_type, $target_id, $voter, $is_upvote);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    public function voteExisted($target_type, $target_id, $voter, $is_upvote) {
        $sql = "SELECT * FROM voting WHERE target_type = ? AND target_id = ? AND voter = ? AND is_upvote = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisi", $target_type, $target_id, $voter, $is_upvote);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    public function countVotesByTargetTypeAndId($target_type, $target_id) {
        $sql_upvotes = "SELECT COUNT(*) AS upvotes FROM voting WHERE target_type = ? AND target_id = ? AND is_upvote = 1";
        $stmt_upvotes = $this->conn->prepare($sql_upvotes);
        $stmt_upvotes->bind_param("ii", $target_type, $target_id);
        $stmt_upvotes->execute();
        $result_upvotes = $stmt_upvotes->get_result();
        $upvotes = $result_upvotes->fetch_assoc()["upvotes"];
        $stmt_upvotes->close();

        $sql_downvotes = "SELECT COUNT(*) AS downvotes FROM voting WHERE target_type = ? AND target_id = ? AND is_upvote = 0";
        $stmt_downvotes = $this->conn->prepare($sql_downvotes);
        $stmt_downvotes->bind_param("ii", $target_type, $target_id);
        $stmt_downvotes->execute();
        $result_downvotes = $stmt_downvotes->get_result();
        $downvotes = $result_downvotes->fetch_assoc()["downvotes"];
        $stmt_downvotes->close();

        return $upvotes - $downvotes;
    }
}
