<?php include "views/includes/header.php"; ?>

<?php if (isset($_SESSION['username'])) : ?>
<!-- All posts -->
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-6">All posts</h1>
        </div>
    </div>

    <!-- Fetch all posts and show them as cards -->
    <?php
        $postsctrl = new PostCtrl();
        $posts = $postsctrl->fetchAllPostsNotByCurrentUser();

        foreach ($posts as $post) : ?>

    <div class="card m-4">
        <div class="card-body">
            <h5 class="card-title"><?= $post['title']; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted">
                <i>by </i><b><?= $post['author']; ?></b>
                &nbsp;&nbsp;
                |
                &nbsp;&nbsp;
                <i>on </i>
                <?= $post['date_created']; ?>
            </h6>
            <hr>
            <p class="card-text"><?php
                                            // show only first 100 characters of the post body
                                            $body = $post['body'];
                                            if (strlen($body) > 100) {
                                                $body = substr($body, 0, 100) . "...";
                                            }
                                            echo $body;
                                            ?></p>
            <button class="btn btn-info" type="button"
                onclick="location.href='<?= ROOT; ?>posts/view/<?= $post['id']; ?>'">
                <i class="fa-solid fa-eye"></i>
                <b>Read</b>
            </button>
        </div>
    </div>

    <?php endforeach; ?>
</div>

<?php else : ?>

<!-- Welcome -->
<div class="jumbotron">
    <div class="container">
        <div class="row align-items-md-stretch">
            <div class="col-12">
                <div
                    class="h-100 p-5 text-white bg-info border rounded-3 d-flex flex-column align-items-center justify-content-center">
                    <h1>BLUDIST</h1>
                    <h5>Blur the distance - Flatten the world</h5>
                    <button class="btn btn-warning m-4" type="button"
                        onclick="location.href='<?= ROOT; ?>login'">
                        <i class="fa-solid fa-user-plus"></i>
                        <b>Join now!</b>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?php include "views/includes/footer.php"; ?>