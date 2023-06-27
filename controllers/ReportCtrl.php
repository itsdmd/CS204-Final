<?php

class ReportCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function addReport($target_type, $target_id, $reporter) {
        $rptmdl = new Report($this->conn);
        $rptmdl->addReport($target_type, $target_id, $reporter);
    }

    public function deleteReport($target_type, $target_id, $reporter) {
        $rptmdl = new Report($this->conn);
        $rptmdl->deleteReport($target_type, $target_id, $reporter);
    }

    public function reportExisted($target_type, $target_id, $reporter) {
        $rptmdl = new Report($this->conn);
        return $rptmdl->reportExisted($target_type, $target_id, $reporter);
    }

    public function countReportsByTargetId($target_id) {
        $rptmdl = new Report($this->conn);
        return $rptmdl->countReportsByTargetId($target_id);
    }
}
