<?php
include "views/includes/header.php";

?>

<div class="container mt-5 p-5">
    <div class="row">
        <div class="col-12">
            <h1>Posts</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="<?= ROOT ?>posts/create" class="btn btn-info"><i class="fa-solid fa-plus"></i> Create new
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
                                <div class="d-flex">
                                    <button class="btn btn-warning" type="button" onclick="location.href='<?= ROOT; ?>posts/edit/<?= $post['id']; ?>'">
                                        <i class="fa-solid fa-pen"></i>
                                        <b>Edit</b>
                                    </button>

                                    <form method="post" action="<?= ROOT ?>posts/delete">
                                        <button type="submit" name="post-id" value="<?= $post["id"] ?>" class="btn btn-danger ml-1"><i class="fa-solid fa-trash"></i>
                                            Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
</div>

<div class="container p-5">
    <div class="row">
        <div class="col-12">
            <a href="<?= ROOT ?>logout" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>