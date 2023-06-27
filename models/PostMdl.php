<?php

class Post {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchPostById($id) {
        $deletedCtrl = new DeletedCtrl();
        if ($deletedCtrl->itemIsHidden(0, $id)) {
            return [];
        }

        $sql = "SELECT * FROM post WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function fetchAllPosts($offset, $limit) {
        $offset = intval($offset);
        $offset = $offset * 10;
        $limit = intval($limit);

        if ($limit == -1) {
            $sql = "SELECT * FROM post LIMIT 99999999 OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $offset);
        } else {
            $sql = "SELECT * FROM post LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $limit, $offset);
        }
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
    }

    public function fetchAllPostsByCurrentUser($offset, $limit) {
        $offset = intval($offset);
        $offset = $offset * 10;
        $limit = intval($limit);

        if ($limit == -1) {
            $sql = "SELECT * FROM post WHERE author = ? LIMIT 99999999 OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $_SESSION["username"], $offset);
        } else {
            $sql = "SELECT * FROM post WHERE author = ? LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $_SESSION["username"], $limit, $offset);
        }
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
    }

    public function fetchAllPostsNotByCurrentUser($offset, $limit) {
        $offset = intval($offset);
        $offset = $offset * 10;
        $limit = intval($limit);

        if ($limit == -1) {
            $sql = "SELECT * FROM post WHERE author != ? LIMIT 99999999 OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $_SESSION["username"], $offset);
        } else {
            $sql = "SELECT * FROM post WHERE author != ? LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $_SESSION["username"], $limit, $offset);
        }
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
    }

    public function fetchPostsByMatched($type, $needle) {
        $sql = "SELECT * FROM post WHERE author != ? AND LOWER(" . $type . ") LIKE LOWER('%" . $needle . "%')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
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
