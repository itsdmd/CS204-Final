<?php
include "views/includes/header.php";
?>

<div class="container mt-5 p-5">
    <div class="row">
        <div class="col-12">
            <h1>Profile</h1>
        </div>
    </div>
    <!-- Avatar -->
    <div class="row">
        <div class="col-12 mt-3">
            <img src="<?php
                        $userCtrl = new UserCtrl();
                        if ($userCtrl->getUserAvatarId($_SESSION['username'])) {
                            echo ROOT . 'img/uploads/' . $userCtrl->getUserAvatarPath($_SESSION['username']);
                        } else {
                            echo ROOT . 'img/default_avatar.png"';
                        }
                        ?>" alt="avatar" width="120" height="120" class="rounded-circle" style="cursor: pointer" data-toggle="modal" data-target="#avatarModal">
            <h2 class="mt-3"><?= $_SESSION['username']; ?></h2>
            <hr>

            <!-- Avatar -->
            <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="avatarModalLabel">Update
                                avatar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- upload file form -->
                            <div>
                                <form action="<?= ROOT . "upload/avatar" ?>" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Upload
                                            file</label>
                                        <input class="form-control" type="file" id="formFile" name="file">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1>Posts</h1>
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
                    foreach ($posts->fetchAllPostsByCurrentUser(0, -1) as $post) :
                    ?>
                        <tr>
                            <td><?= $post["id"] ?></td>
                            <td><?= $post["title"] ?></td>
                            <td><?= $post["date_created"] ?></td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-outline-info" type="button" onclick="location.href='<?= ROOT; ?>posts/view/<?= $post['id']; ?>'">
                                        <i class="fa-solid fa-eye"></i>
                                        <!-- <b>View</b> -->
                                    </button>

                                    <button class="btn btn-outline-warning ml-1" type="button" onclick="location.href='<?= ROOT; ?>posts/edit/<?= $post['id']; ?>'">
                                        <i class="fa-solid fa-pen"></i>
                                        <!-- <b>Edit</b> -->
                                    </button>

                                    <form method="post" action="<?= ROOT ?>posts/delete">
                                        <button type="submit" name="post-id" value="<?= $post["id"] ?>" class="btn btn-outline-danger ml-1"><i class="fa-solid fa-trash"></i>
                                            <!-- <b>Delete</b> -->
                                        </button>
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
            <a href="<?= ROOT ?>logout" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i>
                Logout</a>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>