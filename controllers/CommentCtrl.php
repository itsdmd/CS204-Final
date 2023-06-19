<?php

class CommentCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addComment($author, $type, $reply_to, $body) {
        $cmtmdl = new Comment($this->conn);
        $cmtmdl->addComment($author, $type, $reply_to, $body);
    }

    public function fetchAllCommentsByTargetId($type, $id) {
        $cmtmdl = new Comment($this->conn);
        return $cmtmdl->fetchAllCommentsByTargetId($type, $id);
    }

    public function generateCommentChain($comment, $current_level) {
        $html  = "<div class='col-12";
        if ($current_level < 0) {
            $current_level = 0;
        }
        if ($current_level >= 0 && $current_level < 5) {
            $html .= " ml-" . ($current_level);
        } else {
            $html .= " ml-5";
        }
        $html .= "'>";

        $html .= "<p><b>" . $comment["author"] . "</b> <i class='text-secondary'>said:</i></p>";
        $html .= "<p>" . $comment["body"] . "</p>";
        $html .= "<p class='text-secondary'><i>on</i> " . $comment["date_created"] . "</p>";
        $html .= "<hr>";
        $html .= "</div>";

        foreach ($this->fetchAllCommentsByTargetId(1, $comment["id"]) as $reply) {
            $html .= $this->generateCommentChain($reply, $current_level + 1);
        }

        return $html;
    }

    public function generateCommentSection() {
        $cmtctrl = new CommentCtrl();
        foreach ($cmtctrl->fetchAllCommentsByTargetId(0, $_GET["id"]) as $comment) {
            echo $cmtctrl->generateCommentChain($comment, 0);
        }
    }
}
