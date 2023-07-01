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

    <div class="row mt-4">
        <div class="col-12">
            <h1>My Posts</h1>
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
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Date created</th>
                        <th>Actions</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $postCtrl = new PostCtrl();
                    $votingCtrl = new VotingCtrl();

                    foreach ($postCtrl->fetchAllPostsByUsername($_SESSION["username"], 0, -1) as $post) :
                        $voting_score = $votingCtrl->votingScore($post["id"], NULL);
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
                            <td>
                                <p class="text-<?= ($voting_score > 0) ? "success" : (($voting_score == 0) ? "secondary" : "danger") ?>" style="font-size: 1.2rem;">
                                    <b>
                                        <?= $voting_score ?></b>
                                </p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>

    <?php
    if ($_SESSION["role"] == "0") :
    ?>
        <div class="row mt-4">
            <div class="col-12">
                <h1>User Management</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Username</th>
                            <th>Posts</th>
                            <th>Reports</th>
                            <th>Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userCtrl = new UserCtrl();
                        $votingCtrl = new VotingCtrl();
                        $reportCtrl = new ReportCtrl();
                        $postCtrl = new PostCtrl();

                        $users = array();

                        foreach ($userCtrl->getAllUsers() as $user) {
                            if ($user["username"] == $_SESSION["username"]) continue; // skip current user

                            $post_count = $postCtrl->countPostsByUsername($user["username"]);

                            $voting_score = 0;
                            foreach ($postCtrl->fetchAllPostsByUsername($user["username"], 0, -1) as $post) {
                                $voting_score += $votingCtrl->votingScore($post["id"], NULL);
                            }

                            $reported_posts = $reportCtrl->getReportsByTargetId(2, $user["username"]);
                            $reported_posts_id = array();
                            foreach ($reported_posts as $report) {
                                array_push($reported_posts_id, $report["post_id"]);
                            }

                            $report_count = $reportCtrl->countReportsByTargetId(2, $user["username"]);

                            $user["post_count"] = $post_count;
                            $user["voting_score"] = $voting_score;
                            $user["report_count"] = $report_count;
                            $user["reported_posts_id"] = $reported_posts_id;

                            array_push($users, $user);
                        }

                        // sort users by report count, descending
                        usort($users, function ($a, $b) {
                            return $b["report_count"] - $a["report_count"];
                        });

                        foreach ($users as $user) :
                            $post_count = $user["post_count"];
                            $voting_score = $user["voting_score"];
                            $report_count = $user["report_count"];
                            $reported_posts_id = $user["reported_posts_id"];
                        ?>
                            <tr>
                                <td><?= $user["username"] ?></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <b><?= $post_count ?></b>

                                        <?php if ($post_count > 0) : ?>
                                            <form action="<?= ROOT . 'posts/search' ?>" method="get">
                                                <input type="hidden" name="type" value="author">
                                                <input type="hidden" name="needle" value="<?= $user["username"] ?>">
                                                <button type="submit" class="btn btn-outline-info ml-1"><i class="fa-solid fa-eye"></i></button>
                                                <!-- <b>View</b> -->
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-<?= ($report_count < 5) ? "secondary" : "danger" ?>" style="font-size: 1.2rem;">
                                            <b><?= $report_count ?></b>
                                        </p>

                                        <?php if ($report_count > 0) : ?>
                                            <form action="<?= ROOT . 'posts' ?>" method="post">
                                                <input type="hidden" name="ids" value="<?= implode(",", $reported_posts_id) ?>">
                                                <button type="submit" class="btn btn-outline-info ml-1"><i class="fa-solid fa-eye"></i></button>
                                                <!-- <b>View</b> -->
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-<?= ($voting_score > 0) ? "success" : (($voting_score == 0) ? "secondary" : "danger") ?>" style="font-size: 1.2rem;">
                                        <b><?= $voting_score ?></b>
                                    </p>
                                </td>
                                <td>
                                    <?php if ($user["role"] == 1) : ?>
                                        <div class="d-flex">
                                            <form method="post" action="<?= ROOT ?>posts/delete">
                                                <button type="submit" name="username" value="<?= $user["username"] ?>" class="btn btn-outline-danger ml-1"><i class="fa-solid fa-trash"></i>
                                                    <!-- <b>Delete</b> -->
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class=" container p-5">
    <div class="row">
        <div class="col-12">
            <a href="<?= ROOT ?>logout" class="btn btn-danger"><i class="fa-solid fa-arrow-right-from-bracket"></i>
                Logout</a>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>