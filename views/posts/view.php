<?php
include "views/includes/header.php";

$postCtrl = new PostCtrl();
$url_exploded = explode("/", $_GET["url"]);
$post = $postCtrl->fetchPostById(end($url_exploded));

$votingCtrl = new VotingCtrl();
$vote_count = $votingCtrl->votingScore(0, $post["id"]);
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
            <p><?= $post["content"] ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="text-secondary"><b>Tags:</b>
                <?php
                $tags = explode(",", $post["tags"]);
                foreach ($tags as $key => $tag) {
                    $tags[$key] = trim($tag);
                }
                foreach ($tags as $tag) : ?>
            <div class="badge bg-info text-light"><?= $tag ?></div>
            <?php endforeach; ?>

            </p>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-1">
                <b>
                    <p
                        class="<?= ($vote_count > 0) ? "text-bg-success" : "text-bg-danger" ?> mr-4">
                        <?= $vote_count ?> votes</p>
                </b>
                <!-- voting buttons -->
                <form action="<?= ROOT ?>posts/voting" method="POST">
                    <input type="hidden" name="target-id"
                        value="<?= $post["id"] ?>">
                    <input type="hidden" name="target-type" value="0">
                    <input type="hidden" name="voter"
                        value="<?= $_SESSION["username"] ?>">
                    <input type="hidden" name="is-upvote" value="1">
                    <button type="submit" class="btn btn-success mr-1"><i
                            class="fa-solid fa-arrow-up"></i></button>
                </form>
                <form action="<?= ROOT ?>posts/voting" method="POST">
                    <input type="hidden" name="target-id"
                        value="<?= $post["id"] ?>">
                    <input type="hidden" name="target-type" value="0">
                    <input type="hidden" name="voter"
                        value="<?= $_SESSION["username"] ?>">
                    <input type="hidden" name="is-upvote" value="0">
                    <button type="submit" class="btn btn-danger mr-1"><i
                            class="fa-solid fa-arrow-down"></i></button>
                </form>
            </div>
            <div class="d-flex">
                <a href="<?= ROOT ?>" class="btn btn-warning mr-1"><i
                        class="fa-solid fa-arrow-left"></i> Return</a>
                <form action="<?= ROOT ?>posts/report" method="POST"
                    class="mr-1">
                    <input type="hidden" name="post-id"
                        value="<?= $post["id"] ?>">
                    <button type="submit" class="btn btn-dark"><i
                            class="fa-solid fa-flag"></i> Report</button>
                </form>
                <!-- delete button if current user has role=0 or is the author -->
                <?php if (($_SESSION['role'] == 0) || ($_SESSION['username'] == $post['author'])) : ?>
                <form action="<?= ROOT; ?>posts/delete" method="post">
                    <input type="hidden" name="id" value="<?= $post['id']; ?>">
                    <button class="btn btn-danger" type="submit">
                        <i class="fa-solid fa-trash"></i>
                        <b>Delete</b>
                    </button>
                </form>
                <?php endif; ?>
            </div>
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
                <form action="<?= ROOT ?>comments/add" method="POST"
                    id="comment-form">
                    <input type="hidden" name="post-id"
                        value="<?= $post["id"] ?>">
                    <input type="hidden" name="author"
                        value="<?= $_SESSION["username"] ?>">
                    <input type="hidden" name="type" value="0">
                    <input type="hidden" name="reply_to"
                        value="<?= $post["id"] ?>">
                    <input name="content" class="form-control mb-3"
                        placeholder="Write a comment...">

                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-info"><i
                                class='fa-solid fa-paper-plane'></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $cmtCtrl = new CommentCtrl();
        $cmtCtrl->generateCommentSection();
        ?>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>