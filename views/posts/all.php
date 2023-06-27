<?php include "views/includes/header.php"; ?>

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-6">All posts</h1>
        </div>
    </div>

    <!-- Search bar -->
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" action="<?= ROOT ?>posts/search" method="get">
                <select name="type" id="search-type" class="btn btn-outline-secondary dropdown-toggle mr-2">
                    <option value="title">Title</option>
                    <option value="author">Author</option>
                    <option value="content">Content</option>
                    <option value="tags">Tags</option>
                </select>

                <input type="text" name="needle" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Fetch all posts and show them as cards -->
    <?php
    $postsCtrl = new PostCtrl();
    $posts = null;

    if (isset($_POST["ids"]) && is_array($_POST["ids"]) && count($_POST["ids"]) > 0) {
        foreach ($_POST["ids"] as $id) {
            $posts[] = $postsCtrl->fetchPostById($id);
        }
    } else {
        // page number is the last part of the URL
        $url_parts = explode("/", $_SERVER["REQUEST_URI"]);
        // convert to int
        $page = intval(end($url_parts));
        $posts = $postsCtrl->fetchAllPostsNotByCurrentUser($page - 1, 10);
    }

    foreach ($posts as $post) : ?>

        <div class="card m-4">
            <div class="card-body">
                <h5 class="card-title"><?= $post['title']; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    &nbsp;
                    <img src="<?php
                                $userCtrl = new UserCtrl();
                                if ($userCtrl->getUserAvatarId($post["author"])) {
                                    echo ROOT . 'img/uploads/' . $userCtrl->getUserAvatarPath($post["author"]);
                                } else {
                                    echo ROOT . 'img/default_avatar.png"';
                                }
                                ?>" alt="avatar" width="20" height="20" class="rounded-circle">
                    <b><?= $post['author']; ?></b>
                    &nbsp;&nbsp;
                    |
                    &nbsp;&nbsp;
                    <i>on </i>
                    <?= $post['date_created']; ?>
                </h6>
                <hr>
                <p class="card-text"><?php
                                        // show only first 100 characters of the post content
                                        $content = $post['content'];
                                        if (strlen($content) > 100) {
                                            $content = substr($content, 0, 100) . "...";
                                        }
                                        echo $content;
                                        ?></p>
                <div class="d-flex">
                    <button class="btn btn-info mr-2" type="button" onclick="location.href='<?= ROOT; ?>posts/view/<?= $post['id']; ?>'">
                        <i class="fa-solid fa-eye"></i>
                        <b>Read</b>
                    </button>
                    <!-- delete button if current user has role=0 -->
                    <?php if ($_SESSION['role'] == 0) : ?>
                        <form action="<?= ROOT; ?>posts/delete" method="post">
                            <input type="hidden" name="post-id" value="<?= $post['id']; ?>">
                            <button class="btn btn-outline-danger" type="submit">
                                <i class="fa-solid fa-trash"></i>
                                <b>Delete</b>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <!-- pagination -->
    <nav aria-label="Page navigation" class="d-flex justify-content-end">
        <ul class="pagination">
            <?php
            $allPosts = $postsCtrl->fetchAllPostsNotByCurrentUser(0, -1);
            $pagesCount = ceil(count($allPosts) / 10);

            for ($i = 1; $i <= $pagesCount; $i++) : ?>
                <li class="page-item <?php if ($page == $i) {
                                            echo "active";
                                        } ?>">
                    <a class="page-link" href="<?= ROOT; ?>posts/<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>


<?php include "views/includes/footer.php"; ?>