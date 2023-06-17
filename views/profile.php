<?php include "views/includes/header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Posts</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="<?= ROOT ?>posts/create" class="btn btn-primary">Create new
                post</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Date created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $posts = new PostCtrl();
                    foreach ($posts->fetchAllPostsByCurrentUser() as $post) :
                    ?>
                        <tr>
                            <td><?= $post["id"] ?></td>
                            <td><?= $post["title"] ?></td>
                            <td><?= $post["date_created"] ?></td>
                            <td>
                                <a href="<?= ROOT ?>posts/edit/<?= $post["id"] ?>" class="btn btn-warning">Edit</a>
                                <a href="<?= ROOT ?>posts/delete/<?= $post["id"] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="<?= ROOT ?>logout" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>