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
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchPostById($id);
    }

    public function fetchAllPosts() {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchAllPosts();
    }

    public function fetchAllPostsByCurrentUser() {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchAllPostsByCurrentUser();
    }

    public function fetchAllPostsNotByCurrentUser() {
        $postCtrl = new Post($this->conn);
        return $postCtrl->fetchAllPostsNotByCurrentUser();
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

    public function reportPost($id) {
        $rptCtrl = new Report($this->conn);
        $rptCtrl->addReport(0, $id, $_SESSION["username"]);
    }
}
