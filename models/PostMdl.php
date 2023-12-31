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
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function fetchAllPosts($offset, $limit) {
        $offset = intval($offset);
        $offset = $offset * 5;
        $limit = intval($limit);

        if ($limit == -1) {
            $sql = "SELECT * FROM post ORDER BY date_created DESC, title ASC LIMIT 99999999 OFFSET ? ORDER BY id DESC";
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

    public function fetchAllPostsByUsername($username, $offset, $limit) {
        $offset = intval($offset);
        $offset = $offset * 5;
        $limit = intval($limit);

        if ($limit == -1) {
            $sql = "SELECT * FROM post WHERE author = ? ORDER BY date_created DESC, title ASC LIMIT 99999999 OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $username, $offset);
        } else {
            $sql = "SELECT * FROM post WHERE author = ? ORDER BY date_created DESC, title ASC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $username, $limit, $offset);
        }
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
    }

    public function fetchAllPostsNotByUsername($username, $offset, $limit) {
        $offset = intval($offset);
        $offset = $offset * 5;
        $limit = intval($limit);

        if ($limit == -1) {
            $sql = "SELECT * FROM post WHERE author != ? ORDER BY date_created DESC, title ASC LIMIT 99999999 OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $username, $offset);
        } else {
            $sql = "SELECT * FROM post WHERE author != ? ORDER BY date_created DESC, title ASC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sii", $username, $limit, $offset);
        }
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
    }

    public function fetchPostsByMatched($type, $needle) {
        $sql = "SELECT * FROM post WHERE author != ? AND LOWER(" . $type . ") LIKE LOWER('%" . $needle . "%') ORDER BY date_created DESC, title ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(0, $results);
    }

    public function countPostsByUsername($username) {
        $sql = "SELECT COUNT(*) FROM post WHERE author = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["COUNT(*)"];
    }

    public function setPostMedia($id, $media) {
        $sql = "UPDATE post SET media_id = ? WHERE id = ? ORDER BY date_created DESC, title ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $media, $id);
        $stmt->execute();
    }

    public function getPostMediaId($post_id) {
        $sql = "SELECT media_id FROM post WHERE id = ? ORDER BY date_created DESC, title ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["media_id"];
    }

    public function createPost($title, $content, $author, $tags) {
        $sql = "INSERT INTO post (title, content, author, tags) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $content, $author, $tags);
        $stmt->execute();

        // get the id of the post that was just created
        $sql = "SELECT id FROM post WHERE title = ? AND content = ? AND author = ? AND tags = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $content, $author, $tags);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_assoc()["id"];

        return $id;
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
