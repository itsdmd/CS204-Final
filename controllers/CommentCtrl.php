<?php

class CommentCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addComment($author, $type, $reply_to, $content) {
        $cmtmdl = new Comment($this->conn);
        $cmtmdl->addComment($author, $type, $reply_to, $content);
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
        $html  = "<div class='col-12'";
        if ($current_level < 0) {
            $current_level = 0;
        }
        if ($current_level >= 0 && $current_level < 5) {
            $html .= " ml-" . ($current_level);
        } else {
            $html .= " ml-5";
        }
        $html .= "'>";

        $html .= "  <p><b>" . $comment["author"] . "</b> <i class='text-secondary'>said:</i></p>";
        $html .= "  <p>" . $comment["content"] . "</p>";
        $html .= "  <p class='text-secondary'><i>on</i> " . $comment["date_created"] . "</p>";

        // reply form
        $exploded_url = explode("/", $_GET["url"]);
        $current_post_id = end($exploded_url);
        $html .= "  <div class='mb-3 d-flex flex-column'>";
        $html .= "      <form action='" . ROOT . "comments/add' method='POST' id='comment-form' class='d-flex align-items-center'>";
        $html .= "          <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
        $html .= "          <input type='hidden' name='author' value='" . $_SESSION["username"] . "'>";
        $html .= "          <input type='hidden' name='type' value='1'>";
        $html .= "          <input type='hidden' name='reply_to' value='" . $comment["id"] . "'>";
        $html .= "          <input name='content' class='form-control' placeholder='Write a reply...'>";

        // submit reply button
        $html .= "          <button type='submit' class='btn btn-info ml-2'><i class='fa-solid fa-paper-plane'></i></button>";
        $html .= "      </form>";
        $html .= "  </div>";

        $html .= "</div>";



        $html .= "<div class='col-12 d-flex justify-content-end align-items-center'>";

        // voting count
        $votectrl = new VotingCtrl();
        $vote_count = $votectrl->votingScore(1, $comment["id"]);
        $html .= "  <p class='text-secondary'><b>" . $vote_count . "</b> votes</p>";

        // voting buttons
        $html .= "  <div class='d-flex gap-1'>";
        $html .= "      <form action='" . ROOT . "comments/voting' method='POST'>";
        $html .= "          <input type='hidden' name='target-id' value='" . $comment["id"] . "'>";
        $html .= "          <input type='hidden' name='target-type' value='1'>";
        $html .= "          <input type='hidden' name='voter' value='" . $_SESSION["username"] . "'>";
        $html .= "          <input type='hidden' name='is-upvote' value='1'>";
        $html .= "          <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
        $html .= "          <button type='submit' class='btn btn-success mr-1'><i class='fa-solid fa-arrow-up'></i></button>";
        $html .= "      </form>";

        $html .= "      <form action='" . ROOT . "comments/voting' method='POST'>";
        $html .= "          <input type='hidden' name='target-id' value='" . $comment["id"] . "'>";
        $html .= "          <input type='hidden' name='target-type' value='1'>";
        $html .= "          <input type='hidden' name='voter' value='" . $_SESSION["username"] . "'>";
        $html .= "          <input type='hidden' name='is-upvote' value='0'>";
        $html .= "          <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
        $html .= "          <button type='submit' class='btn btn-danger mr-1'><i class='fa-solid fa-arrow-down'></i></button>";
        $html .= "      </form>";
        $html .= "  </div>";

        // report button
        $html .= "  <form action='" . ROOT . "comments/report' method='POST'>";
        $html .= "      <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
        $html .= "      <input type='hidden' name='comment-id' value='" . $comment["id"] . "'>";
        $html .= "      <button type='submit' class='btn btn-dark'><i class='fa-solid fa-flag'></i></button>";
        $html .= "  </form>";

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
