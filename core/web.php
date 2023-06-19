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

Router::get("posts/view?id={id}", function () {
    $post = new PostCtrl();
    $post->viewPost();
});

Router::get("posts/create", function () {
    $post = new PostCtrl();
    $post->viewCreatePostPage();
});

Router::post("posts/create", function () {
    $post = new PostCtrl();
    $post->createPost();
    header("Location: " . ROOT . "profile");
});

Router::get("posts/edit?id={id}", function () {
    $post = new PostCtrl();
    $post->viewEditPostPage();
});

Router::post("posts/edit/submit", function () {
    $post = new PostCtrl();
    $post->editPost($_POST["post-id"]);
    header("Location: " . ROOT . "profile");
});

Router::post("posts/delete", function () {
    $post = new PostCtrl();
    $post->deletePost($_POST["post-id"]);
    header("Location: " . ROOT . "profile");
});

Router::post("comments/add", function () {
    $comment = new CommentCtrl();
    $comment->addComment($_POST["author"], $_POST["type"], $_POST["reply_to"], $_POST["body"]);

    header("Location: " . ROOT . "posts/view?id=" . $_POST["post-id"]);
});

if (Router::$found === false) {
    include "views/_404.php";
}
