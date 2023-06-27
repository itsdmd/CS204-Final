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
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchPostById($id);
    }

    public function fetchAllPosts($offset, $limit) {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchAllPosts($offset, $limit);
    }

    public function fetchAllPostsByCurrentUser($offset, $limit) {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchAllPostsByCurrentUser($offset, $limit);
    }

    public function fetchAllPostsNotByCurrentUser($offset, $limit) {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchAllPostsNotByCurrentUser($offset, $limit);
    }

    public function searchPosts($type, $needle) {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchPostsByMatched($type, $needle);
    }

    public function createPost() {
        $post = new Post($this->conn);

        $title = $_POST["post-title"];
        $content = $_POST["post-content"];
        $author = $_SESSION["username"];
        $tags = $_POST["post-tags"];

        $post->createPost($title, $content, $author, $tags);
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
