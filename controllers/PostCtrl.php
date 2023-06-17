<?php

class PostCtrl extends Controller {
    public function __construct() {
        parent::__construct();
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
}
