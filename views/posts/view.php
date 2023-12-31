<?php
include "views/includes/header.php";

$postCtrl = new PostCtrl();
$url_exploded = explode("/", $_GET["url"]);
$post = $postCtrl->fetchPostById(end($url_exploded));

$mediaCtrl = new MediaCtrl();
$mediaPath = $mediaCtrl->getFilePathById($postCtrl->getPostMediaId($post["id"]));

$votingCtrl = new VotingCtrl();
$voting_score = $votingCtrl->votingScore($post["id"], NULL);
$upvote_existed = $votingCtrl->voteExisted($post["id"], NULL, $_SESSION["username"], 1);
$downvote_existed = $votingCtrl->voteExisted($post["id"], NULL, $_SESSION["username"], 0);

$reportCtrl = new ReportCtrl();
$reports = $reportCtrl->getReportsByTargetId(0, $post["id"]);
$report_existed = $reportCtrl->reportExisted($post["id"], NULL, $_SESSION["username"]);
?>

<!-- jumbotron -->
<?php if ($mediaPath) : ?>
    <div class="jumbotron jumbotron-fluid mt-5 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img src="<?= ROOT ?>/img/uploads/<?= $mediaPath ?>" alt="" style="object-fit: cover; max-height: 500px; width: 100%; overflow: hidden;">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="container mt-5 p-5">



    <!-- Title -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-end">
                <h1><?= $post["title"] ?></h1>
                <p class="ml-3 text-secondary">#<?= $post["id"] ?></p>
            </div>
            <p class="text-secondary">
                <i>by</i>
                &nbsp;&nbsp;
                <img src="<?php
                            $userCtrl = new UserCtrl();
                            if ($userCtrl->getUserAvatarId($post["author"])) {
                                echo ROOT . 'img/uploads/' . $userCtrl->getUserAvatarPath($post["author"]);
                            } else {
                                echo ROOT . 'img/default_avatar.png"';
                            }
                            ?>" alt="avatar" width="20" height="20" class="rounded-circle">
                <b><?= $post["author"] ?></b>
                &nbsp;&nbsp;
                |
                &nbsp;&nbsp;
                <i>on</i>
                <?= $post["date_created"] ?>
            </p>
        </div>
    </div>

    <!-- Body -->
    <div class="row mt-5 mb-5">
        <div class="col-12">
            <p><?= $post["content"] ?></p>
        </div>
    </div>

    <!-- Tags -->
    <div class="row">
        <div class="col-12">
            <p class="text-secondary"><b>Tags:</b>
                <?php
                $tags = explode(",", $post["tags"]);
                foreach ($tags as $key => $tag) {
                    $tags[$key] = trim($tag);
                }
                foreach ($tags as $tag) : ?>
                    <a class="badge bg-info text-light" href="<?= ROOT ?>posts/search?type=tags&needle=<?= $tag ?>"><?= $tag ?></a>
                <?php endforeach; ?>

            </p>
            <hr>
        </div>
    </div>

    <!-- Interaction -->
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <!-- Voting -->
            <div class="d-flex gap-1">
                <b>
                    <p class="text-<?= ($voting_score > 0) ? "success" : (($voting_score == 0) ? "secondary" : "danger") ?> mr-4">
                        <?= $voting_score ?> points</p>
                </b>
                <!-- voting buttons -->
                <?php if (isset($_SESSION["role"]) && ($_SESSION["role"] != "-1")) : ?>
                    <form action="<?= ROOT ?>posts/voting" method="POST">
                        <input type="hidden" name="target-id" value="<?= $post["id"] ?>">
                        <input type="hidden" name="target-type" value="0">
                        <input type="hidden" name="voter" value="<?= $_SESSION["username"] ?>">
                        <input type="hidden" name="is-upvote" value="1">
                        <button type="submit" class="btn btn-<?php if ($upvote_existed) {
                                                                    echo "success";
                                                                } else {
                                                                    echo "outline-success";
                                                                } ?> mr-1"><i class="fa-solid fa-arrow-up"></i></button>
                    </form>
                    <form action="<?= ROOT ?>posts/voting" method="POST">
                        <input type="hidden" name="target-id" value="<?= $post["id"] ?>">
                        <input type="hidden" name="target-type" value="0">
                        <input type="hidden" name="voter" value="<?= $_SESSION["username"] ?>">
                        <input type="hidden" name="is-upvote" value="0">
                        <button type="submit" class="btn btn-<?php if ($downvote_existed) {
                                                                    echo "danger";
                                                                } else {
                                                                    echo "outline-danger";
                                                                } ?> mr-1"><i class="fa-solid fa-arrow-down"></i></button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="d-flex">
                <button class="btn btn-warning mr-1" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Return</button>

                <div class="d-flex flex-column align-items-center">
                    <?php if (isset($_SESSION["role"]) && ($_SESSION["role"] != "-1")) : ?>
                        <form action="<?= ROOT ?>posts/report" method="POST" class="mr-1">
                            <input type="hidden" name="post-id" value="<?= $post["id"] ?>">

                            <button <?php if ($report_existed) {
                                        echo "class='btn btn-dark' type='submit'";
                                    } else {
                                        echo "class='btn btn-outline-dark' data-toggle='modal' data-target='#reportPostModal' type='button'";
                                    } ?>><i class="fa-solid fa-flag"></i>
                                Report</button>
                        </form>
                    <?php endif; ?>

                    <!-- Number of report -->
                    <a class="text-dark" style="cursor: pointer;" data-toggle="modal" data-target="#reportsModal">
                        <p class="mb-0">
                            <?= $reportCtrl->countReportsByTargetId(0, $post["id"]) ?>
                            reports
                        </p>
                    </a>
                </div>

                <?php if (isset($_SESSION["role"]) && ($_SESSION["role"] != "-1")) : ?>
                    <!-- Add report modal -->
                    <div class="modal fade" id="reportPostModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <form action="<?= ROOT . "posts/report" ?>" method="post">
                                            <div class="mb-3">
                                                <label for="reason" class="form-label">I want
                                                    to report this post
                                                    because</label>
                                                <!-- multiple choice -->
                                                <select class="form-select" name="reason">
                                                    <option value="It's spam">
                                                        It's a spam</option>
                                                    <option value="It's inappropriate">
                                                        It's
                                                        inappropriate
                                                    </option>
                                                    <option value="It's offensive">
                                                        It's
                                                        offensive</option>
                                                    <option value="It's misleading">
                                                        It's misleading</option>
                                                </select>
                                            </div>

                                            <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
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

                    <!-- Query reports modal -->
                    <div class="modal fade" id="reportsModal" tabindex="-1" role="dialog" aria-labelledby="reportsModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reportsModalLabel">
                                        Reports</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped table-hover mt-3">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Reporter</th>
                                                <th>Reason</th>
                                                <th>Date created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reports as $report) : ?>
                                                <tr>
                                                    <td><?= $report["id"] ?></td>
                                                    <td><?= $report["reporter"] ?></td>
                                                    <td><?= $report["reason"] ?></td>
                                                    <td><?= $report["date_created"] ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($_SESSION["role"] == 0 || $_SESSION["username"] == $report["reporter"]) : ?>
                                                            <div class="d-flex">
                                                                <form action="<?= ROOT . "posts/report" ?>" method="post">
                                                                    <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
                                                                    <input type="hidden" name="username" value="<?= $report["reporter"] ?>">
                                                                    <button type="submit" class="btn btn-outline-danger ml-1"><i class="fa-solid fa-trash"></i>
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- delete button if current user has role=0 or is the author -->
                <?php if (($_SESSION['role'] == 0) || ($_SESSION['username'] == $post['author'])) : ?>
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

    <!-- comment section -->
    <div class="row mt-5 d-flex flex-column">
        <div class="col-12">
            <h3>Comments</h3>
            <hr>
        </div>
        <!-- comment form -->
        <?php if (isset($_SESSION["role"]) && ($_SESSION["role"] != "-1")) : ?>
            <div class="col-12">
                <div class="mb-3 d-flex flex-column">
                    <form action="<?= ROOT ?>comments/add" method="POST" id="comment-form">
                        <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
                        <input type="hidden" name="author" value="<?= $_SESSION["username"] ?>">
                        <input type="hidden" name="type" value="0">
                        <input type="hidden" name="replied-to" value="<?= $post["id"] ?>">
                        <input name="content" class="form-control mb-3" placeholder="Write a comment...">

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-info"><i class='fa-solid fa-paper-plane'></i>
                                Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php
        endif;

        $cmtCtrl = new CommentCtrl();
        $cmtCtrl->generateCommentSection();
        ?>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>