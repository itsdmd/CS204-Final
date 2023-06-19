<?php

class CommentCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addComment($author, $type, $reply_to, $body) {
        $cmtmdl = new Comment($this->conn);
        $cmtmdl->addComment($author, $type, $reply_to, $body);
    }

    public function reportComment($target_id, $reporter) {
        $rptctrl = new ReportCtrl();
        $rptctrl->addReport(1, $target_id, $reporter);
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

        // reply form
        $exploded_url = explode("/", $_GET["url"]);
        $current_post_id = end($exploded_url);
        $html .= "<div class='mb-3 d-flex flex-column'>";
        $html .= "<form action='" . ROOT . "comments/add' method='POST' id='comment-form'>";
        $html .= "<input type='hidden' name='post-id' value='" . $current_post_id . "'>";
        $html .= "<input type='hidden' name='author' value='" . $_SESSION["username"] . "'>";
        $html .= "<input type='hidden' name='type' value='1'>";
        $html .= "<input type='hidden' name='reply_to' value='" . $comment["id"] . "'>";
        $html .= "<input name='body' class='form-control mb-3' placeholder='Write a reply...'>";
        $html .= "<div class='col-12 d-flex justify-content-end'>";
        $html .= "<div class='d-flex'>";
        $html .= "<button type='submit' class='btn btn-primary mr-1'><i class='fa-solid fa-paper-plane'></i></button>";
        $html .= "</form>";
        $html .= "<form action='" . ROOT . "comments/report' method='POST'>";
        $html .= "<input type='hidden' name='post-id' value='" . $current_post_id . "'>";
        $html .= "<input type='hidden' name='comment-id' value='" . $comment["id"] . "'>";
        $html .= "<button type='submit' class='btn btn-danger'><i class='fa-solid fa-flag'></i></button>";
        $html .= "</form>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";

        $html .= "<hr>";
        $html .= "</div>";

        foreach ($this->fetchAllCommentsByTargetId(1, $comment["id"]) as $reply) {
            $html .= $this->generateCommentChain($reply, $current_level + 1);
        }

        return $html;
    }

    public function generateCommentSection() {
        $cmtctrl = new CommentCtrl();
        $url_exploded = explode("/", $_GET["url"]);
        foreach ($cmtctrl->fetchAllCommentsByTargetId(0, end($url_exploded)) as $comment) {
            echo $cmtctrl->generateCommentChain($comment, 0);
        }
    }
}
