<?php include "views/includes/header.php"; ?>

<div class="container mt-5 p-5">
    <div class="row">
        <div class="col-12">
            <h1>Create New Post</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="<?= ROOT; ?>posts/create" method="post">
                <div class="form-group">
                    <label for="post-title">Title</label>
                    <input type="text" class="form-control" id="post-title" name="post-title" placeholder="Enter post title">
                </div>
                <div class="form-group">
                    <label for="post-body">Body</label>
                    <textarea class="form-control" id="post-body" name="post-body" rows="5" placeholder="Enter post body"></textarea>
                </div>
                <div class="form-group">
                    <label for="post-tags">Tags</label>
                    <input type="text" class="form-control" id="post-tags" name="post-tags" placeholder="Enter post tags (eg. 'science,math,physics')">
                </div>
                <button type="submit" class="btn btn-info">Post</button>
            </form>
        </div>
    </div>
</div>

<?php include "views/includes/footer.php"; ?>