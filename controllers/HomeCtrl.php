<?php

class HomeCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        include "views/home.php";
    }
}
