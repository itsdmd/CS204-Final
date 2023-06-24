<?php

class DeletedCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function deletePost($post_id, $deleter) {
        $postmdl = new Deleted($this->conn);
        $postmdl->deleteItem(0, $post_id, $deleter);
    }

    public function deleteComment($comment_id, $deleter) {
        $cmtmdl = new Deleted($this->conn);
        $cmtmdl->deleteItem(1, $comment_id, $deleter);
    }

    public function itemIsDeleted($type, $id) {
        $deletedmdl = new Deleted($this->conn);
        return $deletedmdl->itemIsDeleted($type, $id);
    }

    public function filterOutDeletedItems($type, $items) {
        $deletedmdl = new Deleted($this->conn);
        foreach ($items as $key => $value) {
            if ($deletedmdl->itemIsDeleted($type, $value["id"])) {
                unset($items[$key]);
            }
        }
        return $items;
    }
}
