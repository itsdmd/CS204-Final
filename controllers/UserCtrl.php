<?php

class UserCtrl extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function viewLoginPage() {
        include "views/login.php";
        $initAdmin = new User($this->conn);
        $initAdmin->initAdmin();
    }

    public function userLogin() {
        $user = new User($this->conn);
        $user->username = $this->req["login-username"];

        if ($user->userExists()) {
            if (password_verify($this->req["login-pwd"], $user->password)) {
                $_SESSION["username"] = $user->username;
                $_SESSION["role"] = $user->role;
                header("Location: " . ROOT . "profile");
            } else {
                echo "Password is incorrect.";
            }
        } else {
            echo "User does not exist.";
        }
    }

    public function userRegister() {
        $user = new User($this->conn);

        if ($user->userExists()) {
            echo "User already exists.";
        } else {
            $user->username = $this->req["username"];
            $user->password = password_hash($this->req["password"], PASSWORD_DEFAULT);
            $user->role = "1";
            $user->createNewUser();
        }
    }
}
