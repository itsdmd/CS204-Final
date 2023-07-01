<?php

class CommentCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addComment($author, $post_id, $replied_to, $content) {
        $cmtmdl = new Comment($this->conn);
        $cmtmdl->addComment($author, $post_id, $replied_to, $content);
    }

    public function deleteComment($comment_id, $deleter) {
        $cmtmdl = new Comment($this->conn);
        $cmtmdl->deleteComment($comment_id, $deleter);
    }

    public function fetchCommentById($id) {
        $cmtmdl = new Comment($this->conn);
        return $cmtmdl->fetchCommentById($id);
    }

    public function fetchAllCommentsByTargetId($type, $id) {
        $cmtmdl = new Comment($this->conn);
        $result = $cmtmdl->fetchAllCommentsByTargetId($type, $id);

        $deletedCtrl = new DeletedCtrl();
        return $deletedCtrl->filterOutHiddenItems(1, $result);
    }

    public function generateCommentChain($comment, $current_level, $replied_to) {
        $voteCtrl = new VotingCtrl();
        $upvote_existed = $voteCtrl->voteExisted(NULL, $comment["id"], $_SESSION["username"], true);
        $downvote_existed = $voteCtrl->voteExisted(NULL, $comment["id"], $_SESSION["username"], false);

        $reportCtrl = new ReportCtrl();
        $report_existed = $reportCtrl->reportExisted(NULL, $comment["id"], $_SESSION["username"]);

        $html  = "<div class='flex-grow-1 pl-3 border-info border-left' style='border-width: 5px; margin-left: " . ($current_level * 20) . "px;'>";

        $html .= "  <p><b>" . $comment["author"] . "</b> ";
        if ($current_level == 0) {
            $html .= "<i class='text-secondary'>commented:</i>";
        } else {
            $html .= "<i class='text-secondary'>replied to #" . $replied_to . ":</i>";
        }
        "</p>";
        $html .= "  <p>" . $comment["content"] . "</p>";
        $html .= "  <p class='text-secondary'><i>on</i> " . $comment["date_created"] . "&nbsp;&nbsp;|&nbsp;#" . $comment["id"] . "</p>";

        // reply form
        $exploded_url = explode("/", $_GET["url"]);
        $current_post_id = end($exploded_url);
        if (isset($_SESSION['role']) && ($_SESSION['role'] != '-1')) {
            $html .= "  <div class='mb-3 d-flex flex-column'>";
            $html .= "      <form action='" . ROOT . "comments/add' method='POST' id='comment-form' class='d-flex align-items-center'>";
            $html .= "          <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
            $html .= "          <input type='hidden' name='author' value='" . $_SESSION["username"] . "'>";
            $html .= "          <input type='hidden' name='type' value='1'>";
            $html .= "          <input type='hidden' name='replied_to' value='" . $comment["id"] . "'>";
            $html .= "          <input name='content' class='form-control' placeholder='Write a reply...'>";

            // submit reply button
            $html .= "          <button type='submit' class='btn btn-info ml-2'><i class='fa-solid fa-paper-plane'></i></button>";
            $html .= "      </form>";
            $html .= "  </div>";
        }

        // $html .= "</div>";



        $html .= "<div class='col-12 d-flex justify-content-end align-items-center'>";

        // voting count
        $voteCtrl = new VotingCtrl();
        $voting_score = $voteCtrl->votingScore(1, $comment["id"]);
        $html .= "  <p class='text-";
        if ($voting_score > 0) {
            $html .= "success";
        } else if ($voting_score < 0) {
            $html .= "danger";
        } else {
            $html .= "secondary";
        }
        $html .= "' ><b>" . $voting_score . "</b> points</p>";

        if (isset($_SESSION['role']) && ($_SESSION['role'] != '-1')) {
            // voting buttons
            $html .= "  <div class='d-flex'>";
            $html .= "      <form action='" . ROOT . "comments/voting' method='POST' class='mr-1'>";
            $html .= "          <input type='hidden' name='target-id' value='" . $comment["id"] . "'>";
            $html .= "          <input type='hidden' name='target-type' value='1'>";
            $html .= "          <input type='hidden' name='voter' value='" . $_SESSION["username"] . "'>";
            $html .= "          <input type='hidden' name='is-upvote' value='1'>";
            $html .= "          <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
            $html .= "          <button type='submit' class='btn btn";
            if (!$upvote_existed) {
                $html .= "-outline";
            }
            $html .= "-success mr-1'><i class='fa-solid fa-arrow-up'></i></button>";
            $html .= "      </form>";

            $html .= "      <form action='" . ROOT . "comments/voting' method='POST' class='mr-2'>";
            $html .= "          <input type='hidden' name='target-id' value='" . $comment["id"] . "'>";
            $html .= "          <input type='hidden' name='target-type' value='1'>";
            $html .= "          <input type='hidden' name='voter' value='" . $_SESSION["username"] . "'>";
            $html .= "          <input type='hidden' name='is-upvote' value='0'>";
            $html .= "          <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
            $html .= "          <button type='submit' class='btn btn";
            if (!$downvote_existed) {
                $html .= "-outline";
            }
            $html .= "-danger mr-1'><i class='fa-solid fa-arrow-down'></i></button>";
            $html .= "      </form>";
            $html .= "  </div>";

            // report button
            if ($_SESSION["role"] != "0") {
                if ($report_existed) {
                    $html .= "  <form action='" . ROOT . "comments/report' method='POST' class='mr-1'>";
                    $html .= "      <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
                    $html .= "      <input type='hidden' name='comment-id' value='" . $comment["id"] . "'>";
                    $html .= "  <button class='btn btn-dark' type='submit'>";
                } else {
                    $html .= "  <button class='btn btn-outline-dark' data-toggle='modal' data-target='#reportCommentModal" . $comment["id"] . "' type='button'>";
                }
                $html .= "<i class='fa-solid fa-flag'></i></button>";

                $html .= "  <div class='modal fade' id='reportCommentModal" . $comment["id"] . "' tabindex='-1' role='dialog'>";
                $html .= "      <div class='modal-dialog' role='document'>";
                $html .= "          <div class='modal-content'>";
                $html .= "              <div class='modal-header'>";
                $html .= "                  <h5 class='modal-title'>Report Comment</h5>";
                $html .= "                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                $html .= "                      <span aria-hidden='true'>&times;</span>";
                $html .= "                  </button>";
                $html .= "              </div>";
                $html .= "              <div class='modal-body'>";
                $html .= "                  <form action='" . ROOT . "comments/report' method='POST'>";
                $html .= "                      <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
                $html .= "                      <input type='hidden' name='comment-id' value='" . $comment["id"] . "'>";
                $html .= "                      <div class='mb-3'>";
                $html .= "                          <label for='reason' class='form-label'>I want to report this comment because</label>";
                $html .= "                          <select class='form-select' name='reason'>";
                $html .= "                              <option value=\"It's spam\">It's spam</option>";
                $html .= "                              <option value=\"It's inappropriate\">It's inappropriate</option>";
                $html .= "                              <option value=\"It's offensive\">It's offensive</option>";
                $html .= "                              <option value=\"It's misleading\">It's misleading</option>";
                $html .= "                          </select>";
                $html .= "                      </div>";
                $html .= "                  <div class='modal-footer'>";
                $html .= "                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                $html .= "                      <button type='submit' class='btn btn-info'>Submit</button>";
                $html .= "                  </div>";
                $html .= "              </form>";
                $html .= "          </div>";
                $html .= "      </div>";
                $html .= "  </div>";
                $html .= "</div>";
            }
        }

        // delete button for role=0 or created by current user
        if (($_SESSION["role"] == 0) || ($_SESSION["username"] == $comment["author"])) {
            $html .= "  <form action='" . ROOT . "comments/delete' method='POST'>";
            $html .= "      <input type='hidden' name='post-id' value='" . $current_post_id . "'>";
            $html .= "      <input type='hidden' name='comment-id' value='" . $comment["id"] . "'>";
            $html .= "      <button type='submit' class='btn btn-outline-danger'><i class='fa-solid fa-trash'></i></button>";
            $html .= "  </form>";
        }

        $html .= "</div>";
        $html .= "</div>";


        foreach ($this->fetchAllCommentsByTargetId(1, $comment["id"]) as $reply) {
            $html .= $this->generateCommentChain(
                $reply,
                $current_level + 1,
                $comment["id"]
            );
        }

        return $html;
    }

    public function generateCommentSection() {
        $cmtCtrl = new CommentCtrl();
        $url_exploded = explode("/", $_GET["url"]);
        foreach ($cmtCtrl->fetchAllCommentsByTargetId(0, end($url_exploded)) as $comment) {
            echo $cmtCtrl->generateCommentChain($comment, 0, end($url_exploded));
        }
    }
}
