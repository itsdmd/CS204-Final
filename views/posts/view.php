<?php
include "views/includes/header.php";
$postctrl = new PostCtrl();
$url_exploded = explode("/", $_GET["url"]);
$post = $postctrl->fetchPostById(end($url_exploded));
?>

<div class="container mt-5 p-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-end">
                <h1><?= $post["title"] ?></h1>
                <p class="ml-3 text-secondary">#<?= $post["id"] ?></p>
            </div>
            <p class="text-secondary">
                <i>by</i>
                <b><?= $post["author"] ?></b>
                &nbsp;&nbsp;
                |
                &nbsp;&nbsp;
                <i>on</i>
                <?= $post["date_created"] ?>
            </p>
        </div>
    </div>
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <p><?= $post["body"] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="text-secondary"><b>Tags:</b> <?= $post["tags"] ?></p>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="<?= ROOT ?>" class="btn btn-warning mr-1"><i class="fa-solid fa-arrow-left"></i> Return</a>
            <!-- report button -->
            <form action="<?= ROOT ?>posts/report" method="POST">
                <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-flag"></i> Report</button>
            </form>
        </div>
    </div>

    <!-- comment section -->

    <div class="row mt-5">
        <div class="col-12">
            <h3>Comments</h3>
            <hr>
        </div>
        <!-- comment form -->
        <div class="col-12">
            <div class="mb-3 d-flex flex-column">
                <form action="<?= ROOT ?>comments/add" method="POST" id="comment-form">
                    <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
                    <input type="hidden" name="author" value="<?= $_SESSION["username"] ?>">
                    <input type="hidden" name="type" value="0">
                    <input type="hidden" name="reply_to" value="<?= $post["id"] ?>">
                    <input name="body" class="form-control mb-3" placeholder="Write a comment...">

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary"><i class='fa-solid fa-paper-plane'></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $cmtctrl = new CommentCtrl();
        $cmtctrl->generateCommentSection();
        ?>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>