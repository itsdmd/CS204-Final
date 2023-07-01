<?php

class ReportCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addReport($post_id, $comment_id, $reporter, $reason) {
        $rptmdl = new Report($this->conn);
        $rptmdl->addReport($post_id, $comment_id, $reporter, $reason);
    }

    public function deleteReport($post_id, $comment_id, $reporter) {
        $rptmdl = new Report($this->conn);
        $rptmdl->deleteReport($post_id, $comment_id, $reporter);
    }

    public function reportExisted($post_id, $comment_id, $reporter) {
        $rptmdl = new Report($this->conn);
        return $rptmdl->reportExisted($post_id, $comment_id, $reporter);
    }

    public function getReportsByTargetId($type, $target_id) {
        $rptmdl = new Report($this->conn);
        return $rptmdl->getReportsByTargetId($type, $target_id);
    }

    public function countReportsByTargetId($type, $target_id) {
        $rptmdl = new Report($this->conn);
        return $rptmdl->countReportsByTargetId($type, $target_id);
    }
}
