<?php

class MediaMdl {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addNewUploadFileEntry($path, $uploader) {
        $sql = "INSERT INTO media (path, uploader) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $path, $uploader);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            return $stmt->insert_id;
        }

        $stmt->close();
    }

    public function getFilePathById($id) {
        $sql = "SELECT path FROM media WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!empty($result)) {
            return $result["path"];
        }

        $stmt->close();
    }

    public function getFileIdByPath($path) {
        $sql = "SELECT id FROM media WHERE path = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $path);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!empty($result)) {
            return $result["id"];
        }

        $stmt->close();
    }
}
