<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" >New Review</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-2">
                <div class="col-md pt-2 text-center">
                <form action="create-post.php" method="POST" id="createPostForm">
                <label for="showSelect">Select show:</label>
                <select name="showSelect" class="form-select form-select-sm mb-3" aria-label="Large select example" id="showSelect">
                <label for="startingOption"><option name="startingOption" selected></option></label>
                    <?php $shows = $db->getShowByUser($_SESSION['user_id']);
                    foreach ($shows as $show):?>
                    <option value="<?php echo $show['showId']?>"><?php echo $api->getTvShowById($show['showId'])['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                    <label for="uploadImg" class="form-label pt-1">Upload image:<input class="form-control form-control-sm" type="file" id="uploadImg" accept="image/png, image/jpg, image/jpeg" name="uploadImg"></label>
                </div>
                <label for="comment">Comment:</label>
                <textarea class="rounded" name="comment" id="comment" cols="30" rows="6" maxlength="255" required></textarea>
                </div>
            <input type="submit" value="Post" class="btn btn-primary my-1" id="createPostBtn">
            </form>
        </div>
    </div>
    <script src="script/createPost.js"></script>
</div>