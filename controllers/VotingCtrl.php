<?php

class VotingCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addVote($post_id, $comment_id, $voter, $is_upvote) {
        $voting = new Voting($this->conn);
        return $voting->addVote($post_id, $comment_id, $voter, $is_upvote);
    }

    public function voteExisted($post_id, $comment_id, $voter, $is_upvote) {
        $voting = new Voting($this->conn);
        return $voting->voteExisted($post_id, $comment_id, $voter, $is_upvote);
    }

    public function votingScore($post_id, $comment_id) {
        $voting = new Voting($this->conn);
        return $voting->votingScore($post_id, $comment_id);
    }
}
