<?php

class PostCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function viewPostsPage() {
        include "views/posts/all.php";
    }

    public function viewPost() {
        include "views/posts/view.php";
    }

    public function viewCreatePostPage() {
        include "views/posts/create.php";
    }

    public function viewEditPostPage() {
        include "views/posts/edit.php";
    }

    public function fetchPostById($id) {
        $postMdl = new Post($this->conn);
        return $postMdl->fetchPostById($id);
    }

    public function fetchAllPosts($offset, $limit) {
        $postMdl = new Post($this->conn);
        return $postMdl->fetchAllPosts($offset, $limit);
    }

    public function fetchAllPostsByUsername($username, $offset, $limit) {
        $postMdl = new Post($this->conn);
        return $postMdl->fetchAllPostsByUsername($username, $offset, $limit);
    }

    public function fetchAllPostsNotByUsername($username, $offset, $limit) {
        $postMdl = new Post($this->conn);
        return $postMdl->fetchAllPostsNotByUsername($username, $offset, $limit);
    }

    public function countPostsByUsername($username) {
        $postMdl = new Post($this->conn);
        return $postMdl->countPostsByUsername($username);
    }

    public function searchPosts($type, $needle) {
        $postMdl = new Post($this->conn);
        return $postMdl->fetchPostsByMatched($type, $needle);
    }

    public function setPostMedia($post_id, $media_id) {
        $postMdl = new Post($this->conn);
        $postMdl->setPostMedia($post_id, $media_id);
    }

    public function getPostMediaId($post_id) {
        $postMdl = new Post($this->conn);
        return $postMdl->getPostMediaId($post_id);
    }

    public function createPost() {
        $post = new Post($this->conn);

        $title = $_POST["post-title"];
        $content = $_POST["post-content"];
        $author = $_SESSION["username"];
        $tags = $_POST["post-tags"];

        return $post->createPost($title, $content, $author, $tags);
    }

    public function editPost($id) {
        $post = new Post($this->conn);

        $title = $_POST["post-title"];
        $content = $_POST["post-content"];
        $tags = $_POST["post-tags"];

        $post->editPost($id, $title, $content, $tags);
    }

    public function deletePost($id) {
        $post = new Post($this->conn);
        $post->deletePost($id);
    }
}
