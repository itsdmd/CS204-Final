<?php
$conn = "";

Router::get("", function () {
    $home = new HomeCtrl();
    $home->index();
});

Router::get("account", function () {
    $user = new UserCtrl();
    $user->viewLoginPage();
});

Router::post("account", function () {
    $user = new UserCtrl();
    $user->userLogin();
});

Router::post("register", function () {
    $user = new UserCtrl();
    $user->userRegister();
});

Router::get("profile", function () {
    $profile = new ProfileCtrl();
    $profile->index();
});

Router::get("logout", function () {
    session_destroy();
    header("Location: " . ROOT);
});

Router::get("posts", function () {
    include "views/posts.php";
});

if (Router::$found === false) {
    include "views/_404.php";
}
