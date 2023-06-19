<?php
$postctrl = new PostCtrl();
$url_exploded = explode("/", $_GET["url"]);
if ($_SESSION["username"] != $postctrl->fetchPostById(end($url_exploded))["author"]) {
    header("Location: " . ROOT . "posts/view/" . end($url_exploded));
    exit();
}

include "views/includes/header.php";
$post = $postctrl->fetchPostById(end($url_exploded));
?>

<div class="container mt-5 p-5">
    <div class="row">
        <div class="col-12">
            <h1>Editing Post #<?= $post["id"] ?></h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="<?php echo ROOT; ?>posts/edit" method="post">
                <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
                <div class="form-group">
                    <label for="post-title">Title</label>
                    <input type="text" class="form-control" id="post-title" name="post-title" placeholder="Enter post title" value="<?= $post["title"] ?>">
                </div>
                <div class="form-group">
                    <label for="post-body">Body</label>
                    <textarea class="form-control" id="post-body" name="post-body" rows="5" placeholder="Enter post body"><?= $post["body"] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="post-tags">Tags</label>
                    <input type="text" class="form-control" id="post-tags" name="post-tags" placeholder="Enter post tags (eg. 'science,math,physics')" value="<?= $post["tags"] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>