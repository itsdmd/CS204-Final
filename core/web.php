<?php
$conn = "";

if (!isset($_SESSION["username"])) {
    $_SESSION["username"] = "guest";
    $_SESSION["role"] = "-1";
}

Router::get("", function () {
    $home = new HomeCtrl();
    $home->index();
});

Router::get("login", function () {
    $user = new UserCtrl();
    $user->viewLoginPage();
});

Router::post("login", function () {
    // if (isset($_SESSION["status"])) {
    //     header("Location: " . ROOT . "login");
    //     exit();
    // }

    $user = new UserCtrl();
    $user->userLogin();
});

Router::post("register", function () {
    $user = new UserCtrl();
    $_SESSION = array();
    $_SESSION["status"] = $user->userRegister();

    header("Location: " . ROOT . "login");
});

Router::get("profile", function () {

    $profile = new ProfileCtrl();
    $profile->viewProfilePage();
});

Router::get("logout", function () {
    session_destroy();
    header("Location: " . ROOT);
});

Router::get("posts", function () {
    $postCtrl = new PostCtrl();
    $postCtrl->viewPostsPage();
});

Router::get("posts/view/{id}", function () {
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

Router::get("posts/edit/{id}", function () {
    $post = new PostCtrl();
    $post->viewEditPostPage();
});

Router::post("posts/edit", function () {
    $post = new PostCtrl();
    $post->editPost($_POST["post-id"]);
    header("Location: " . ROOT . "profile");
});

Router::post("posts/delete", function () {
    // get current url
    $postCtrl = new PostCtrl();
    $post = $postCtrl->fetchPostById($_POST["post-id"]);
    if ($post["author"] == $_SESSION["username"]) {
        $url = "profile";
    } else {
        $url = "posts";
    }

    $deletedCtrl = new DeletedCtrl();
    $deletedCtrl->deletePost($_POST["post-id"], $_SESSION["username"]);

    header("Location: " . ROOT . $url);
});

Router::post("posts/report", function () {
    $post = new PostCtrl();
    $post->reportPost($_POST["post-id"]);
    header("Location: " . ROOT . "posts/view/" . $_POST["post-id"]);
});

Router::post("posts/voting", function () {
    $post = new VotingCtrl();
    $post->addVote($_POST["target-type"], $_POST["target-id"], $_POST["voter"], $_POST["is-upvote"]);
    header("Location: " . ROOT . "posts/view/" . $_POST["target-id"]);
});

Router::get("posts/search", function () {
    if ((!isset($_GET["type"]) || !isset($_GET["needle"])) || ($_GET["type"] == "" || $_GET["needle"] == "")) {
        header("Location: " . ROOT);
        exit();
    }

    $postCtrl = new PostCtrl();
    $posts = $postCtrl->searchPosts($_GET["type"], $_GET["needle"]);

    // get id of all posts
    $ids = array();
    foreach ($posts as $post) {
        array_push($ids, $post["id"]);
    }

    // attach to $_POST
    $_POST["ids"] = $ids;

    $postCtrl->viewPostsPage();
});

Router::post("comments/add", function () {
    $comment = new CommentCtrl();
    $comment->addComment($_POST["author"], $_POST["type"], $_POST["reply_to"], $_POST["content"]);

    header("Location: " . ROOT . "posts/view/" . $_POST["post-id"]);
});

Router::post("comments/delete", function () {
    $deletedCtrl = new DeletedCtrl();
    $deletedCtrl->deleteComment($_POST["comment-id"], $_SESSION["username"]);

    header("Location: " . ROOT . "posts/view/" . $_POST["post-id"]);
});

Router::post("comments/report", function () {
    $comment = new CommentCtrl();
    $comment->reportComment($_POST["comment-id"], $_SESSION["username"]);

    header("Location: " . ROOT . "posts/view/" . $_POST["post-id"]);
});

Router::post("comments/voting", function () {
    $post = new VotingCtrl();
    $post->addVote($_POST["target-type"], $_POST["target-id"], $_POST["voter"], $_POST["is-upvote"]);
    header("Location: " . ROOT . "posts/view/" . $_POST["post-id"]);
});

Router::post("upload/avatar", function () {
    if (!isset($_FILES["file"])) {
        header("Location: " . ROOT . "profile");
        exit();
    }

    $uploadCtrl = new MediaCtrl();
    $file_name = $uploadCtrl->uploadMedia();
    $file_id = $uploadCtrl->getFileIdByPath($file_name);

    $userCtrl = new UserCtrl();
    $userCtrl->setUserAvatar($_SESSION["username"], $file_id);

    header("Location: " . ROOT . "profile");
});

if (Router::$found === false) {
    include "views/_404.php";
}
