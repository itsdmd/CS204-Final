<?php

class PostCtrl extends Controller {
    public function __construct() {
        parent::__construct();
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
        $postctrl = new Post($this->conn);
        return $postctrl->fetchPostById($id);
    }

    public function fetchAllPosts() {
        $postctrl = new Post($this->conn);
        return $postctrl->fetchAllPosts();
    }

    public function fetchAllPostsByCurrentUser() {
        $postctrl = new Post($this->conn);
        return $postctrl->fetchAllPostsByCurrentUser();
    }

    public function fetchAllPostsNotByCurrentUser() {
        $postctrl = new Post($this->conn);
        return $postctrl->fetchAllPostsNotByCurrentUser();
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

    public function reportPost($id) {
        $rptctrl = new Report($this->conn);
        $rptctrl->addReport(0, $id, $_SESSION["username"]);
    }
}
