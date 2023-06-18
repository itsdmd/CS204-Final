<?php
include "views/includes/header.php";
$postctrl = new PostCtrl();
$post = $postctrl->fetchPostById($_POST["post-id"]);
?>

<div class="container mt-5 p-5">
    <div class="row">
        <div class="col-12">
            <h1><?= $post["title"] ?></h1>
            <p><i>by</i> <b><?= $post["author"] ?></b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p><?= $post["body"] ?></p>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p><b>Tags:</b> <?= $post["tags"] ?></p>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p><b>Date created:</b> <?= $post["date_created"] ?></p>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="<?= ROOT ?>" class="btn btn-primary">Return</a>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>