<?php

class DeletedCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function deletePost($post_id, $deleter) {
        $postmdl = new Deleted($this->conn);
        $postmdl->hideItem(0, $post_id, $deleter);
    }

    public function deleteComment($comment_id, $deleter) {
        $cmtmdl = new Deleted($this->conn);
        $cmtmdl->deleteItem(1, $comment_id);
    }

    public function itemIsHidden($type, $id) {
        $deletedmdl = new Deleted($this->conn);
        return $deletedmdl->itemIsHidden($type, $id);
    }

    public function filterOutHiddenItems($type, $items) {
        $deletedmdl = new Deleted($this->conn);
        foreach ($items as $key => $value) {
            if ($deletedmdl->itemIsHidden($type, $value["id"])) {
                unset($items[$key]);
            }
        }
        return $items;
    }
}
