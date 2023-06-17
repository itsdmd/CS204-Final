<?php

class PostCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function viewCreatePostPage() {
        include "views/createPost.php";
    }

    public function viewEditPostPage() {
        include "views/editPost.php";
    }

    public function fetchPostById($id) {
        $post = new Post($this->conn);
        return $post->fetchPostById($id);
    }

    public function fetchAllPosts() {
        $post = new Post($this->conn);
        return $post->fetchAllPosts();
    }

    public function fetchAllPostsByCurrentUser() {
        $post = new Post($this->conn);
        return $post->fetchAllPostsByCurrentUser();
    }

    public function createPost() {
        $post = new Post($this->conn);

        $title = $_POST["post-title"];
        $body = $_POST["post-body"];
        $author = $_SESSION["username"];
        $tags = $_POST["post-tags"];

        $post->createPost($title, $body, $author, $tags);
    }

    public function editPost($id) {
        $post = new Post($this->conn);

        $title = $_POST["post-title"];
        $body = $_POST["post-body"];
        $tags = $_POST["post-tags"];

        $post->editPost($id, $title, $body, $tags);
    }

    public function deletePost($id) {
        $post = new Post($this->conn);
        $post->deletePost($id);
    }
}
