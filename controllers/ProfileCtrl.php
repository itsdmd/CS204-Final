<?php

class ProfileCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        include "views/profile.php";
    }
}
