<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">New Review</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row g-2">
                <div class="col-md pt-2 text-center">
                    <label for="showSelect">Select show:</label>
                <select class="form-select form-select-sm mb-3" aria-label="Large select example" id="showSelect">
                    <option selected></option>
                    <?php $shows = $db->getShowByUser(3);
                    foreach ($shows as $show):?>
                    <option value="<?php echo $show['showId']?>"><?php echo $api->getTvShowById($show['showId'])['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                    <label for="uploadImg" class="form-label pt-1">Upload image:<input class="form-control form-control-sm" type="file" id="uploadImg"></label>
                </div>
                <div class="col-md text-center">
                    <label for="seasonSelect">Season:<select id="seasonSelect" class="form-select mt-2 mx-3" aria-label="Season select" disabled>
                        
                    </select></label>
                    <label for="episodeSelect">Episode: <select id="episodeSelect" class="form-select mt-2 mx-3" aria-label="Episode select" disabled>
                        
                    </select></label>
                </div>
                <label for="comment">Comment:</label>
                <textarea class="rounded" name="comment" id="comment" cols="30" rows="6" required></textarea>
                </div>
            <input type="submit" value="Post" class="btn btn-primary my-1">
        </div>
    </div>
    <script src="script/createPost.js"></script>
</div>