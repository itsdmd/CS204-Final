<?php

class Post {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchPostById($id) {
        $deletedCtrl = new DeletedCtrl();
        if ($deletedCtrl->itemIsDeleted(0, $id)) {
            return [];
        }

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
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutDeletedItems(0, $results);
    }

    public function fetchAllPostsByCurrentUser() {
        $sql = "SELECT * FROM post WHERE author = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutDeletedItems(0, $results);
    }

    public function fetchAllPostsNotByCurrentUser() {
        $sql = "SELECT * FROM post WHERE author != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutDeletedItems(0, $results);
    }

    public function fetchPostsByMatched($type, $needle) {
        $sql = "SELECT * FROM post WHERE author != ? AND LOWER(" . $type . ") LIKE LOWER('%" . $needle . "%')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutDeletedItems(0, $results);
    }

    public function createPost($title, $content, $author, $tags) {
        $sql = "INSERT INTO post (title, content, author, tags) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $content, $author, $tags);
        $stmt->execute();
    }

    public function editPost($id, $title, $content, $tags) {
        $sql = "UPDATE post SET title = ?, content = ?, tags = ?, date_modified = DEFAULT WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $content, $tags, $id);
        $stmt->execute();
    }

    public function deletePost($id) {
        $deleteCtrl = new DeletedCtrl();
        $deleteCtrl->deletePost($id, $_SESSION["username"]);
    }
}
