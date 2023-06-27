<?php

class Report {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addReport($target_type, $target_id, $reporter) {
        if ($this->reportExisted($target_type, $target_id, $reporter)) {
            return;
        }

        $sql = "INSERT INTO report (target_type, target_id, reporter) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $target_type, $target_id, $reporter);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteReport($target_type, $target_id, $reporter) {
        $sql = "DELETE FROM report WHERE target_type = ? AND target_id = ? AND reporter = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $target_type, $target_id, $reporter);
        $stmt->execute();
        $stmt->close();
    }

    public function reportExisted($target_type, $target_id, $reporter) {
        $sql = "SELECT * FROM report WHERE target_type = ? AND target_id = ? AND reporter = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $target_type, $target_id, $reporter);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    public function countReportsByTargetId($target_id) {
        $sql = "SELECT * FROM report WHERE target_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $target_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows;
    }
}
