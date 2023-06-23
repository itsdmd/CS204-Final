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

    public function fetchAllPostsNotByCurrentUser() {
        $sql = "SELECT * FROM post WHERE author != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchPostsByMatched($type, $needle) {
        $sql = "SELECT * FROM post WHERE author != ? AND LOWER(" . $type . ") LIKE LOWER('%" . $needle . "%')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function createPost($title, $body, $author, $tags) {
        $sql = "INSERT INTO post (title, body, author, tags) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $body, $author, $tags);
        $stmt->execute();
    }

    public function editPost($id, $title, $body, $tags) {
        $sql = "UPDATE post SET title = ?, body = ?, tags = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $body, $tags, $id);
        $stmt->execute();
    }

    public function deletePost($id) {
        $sql = "DELETE FROM post WHERE id = ? AND author = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $id, $_SESSION["username"]);
        $stmt->execute();
    }
}
