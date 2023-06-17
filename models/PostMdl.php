<?php

class Post {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchPostById($id) {
        $sql = "SELECT * FROM post WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function fetchAllPosts() {
        $sql = "SELECT * FROM post";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchAllPostsByCurrentUser() {
        $sql = "SELECT * FROM post WHERE author = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }
}
