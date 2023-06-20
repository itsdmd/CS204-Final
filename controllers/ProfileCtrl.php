<?php

class ProfileCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function viewProfilePage() {
        include "views/profile.php";
    }
}
