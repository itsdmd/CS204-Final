<?php

class Controller {
    public $conn;
    public $req;
    public $params;
    public $files;

    public function __construct() {
        $this->conn = DB::getConn();
        $this->req = $_POST;
        $this->params = $_GET;
        $this->files = $_FILES;
        // echo "<pre>", var_dump($this->conn), "</pre>";
        // echo "Parent Conroller class instantiated.";
    }
}