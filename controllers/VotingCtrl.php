<?php

class VotingCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addVote($target_type, $target_id, $voter, $is_upvote) {
        $voting = new Voting($this->conn);
        return $voting->addVote($target_type, $target_id, $voter, $is_upvote);
    }

    public function voteExisted($target_type, $target_id, $voter, $is_upvote) {
        $voting = new Voting($this->conn);
        return $voting->voteExisted($target_type, $target_id, $voter, $is_upvote);
    }

    public function votingScore($target_type, $target_id) {
        $voting = new Voting($this->conn);
        return $voting->votingScore($target_type, $target_id);
    }
}
