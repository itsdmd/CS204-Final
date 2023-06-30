<?php
$postCtrl = new PostCtrl();
$url_exploded = explode("/", $_GET["url"]);
if ($_SESSION["username"] != $postCtrl->fetchPostById(end($url_exploded))["author"]) {
    header("Location: " . ROOT . "posts/view/" . end($url_exploded));
    exit();
}

include "views/includes/header.php";
$post = $postCtrl->fetchPostById(end($url_exploded));
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
            <form action="<?= ROOT; ?>posts/edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post-id" value="<?= $post["id"] ?>">
                <div class="form-group">
                    <label for="file" class="form-label">
                        <i class="fas fa-image"></i> Upload</label>
                    <input class="form-control" type="file" id="file" name="file">
                </div>
                <div class="form-group">
                    <label for="post-title">Title</label>
                    <input type="text" class="form-control" id="post-title" name="post-title" placeholder="Enter post title" value="<?= $post["title"] ?>">
                </div>
                <div class="form-group">
                    <label for="post-content">content</label>
                    <textarea class="form-control" id="post-content" name="post-content" rows="5" placeholder="Enter post content"><?= $post["content"] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="post-tags">Tags</label>
                    <input type="text" class="form-control" id="post-tags" name="post-tags" placeholder="Enter post tags (eg. 'science,math,physics')" value="<?= $post["tags"] ?>">
                </div>
                <button type="submit" class="btn btn-info">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>