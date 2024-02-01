<main class="d-flex justify-content-center">
    <?php $post = $templateParams['post'][0];
    $show = $api->getTvShowById($post['showId']);
    $userName = $db->getUserName($post['userId']) ?>
    <div class="card my-3 mx-3 col-md-8">
        <?php if ($post['img'] != null):?>
        <img class="py-1" src="<?php echo 'upload/' . $post['img'] ?>" alt="">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><a href="#"><?php echo $show['name'];
            if ($post['seasonId'] != null && $post['episodeId'] != null){
              echo " S: " . $post['seasonId'] . "/E: " . $post['episodeId'];
            } elseif($post['seasonId'] != null && $post['episodeId'] == null) {
              echo " S: " . $post['seasonId'];
            }
            ?></a></h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">
              <a href="profile.php?username=<?php echo $userName; ?>"
                ><span class="fa-solid fa-circle-user"></span><?php echo $userName ?></a>
            </h6>
            <p class="card-text"><?php echo $post['paragraph']?></p>
            <button class="btn likeBtn" data-post-id="<?php echo $post['postId'] ?>"><span class="likeNumber"><?php echo $db->getLikeNumber($post['postId']); ?> </span><span class="likeIcon <?php $db->getLikedPost(3, $post['postId']) ?>"></span></button>
            <button
              class="btn"
              id="commentBtn<?php echo $post['postId'];?>"
            >
            <?php $comments = $db->getComments($post['postId']);
            echo count($comments); ?><span class="fa-regular fa-comment"></span>
            </button>
            <div>
                <div class="singleCommentDiv">
                    <ul class="commList" id="commentList<?php echo $post['postId'];?>">
                    <?php foreach ($comments as $comment):
                    $commUserName = $db->getUserName($comment['userID'])?>
                        <li><a href="profile.php?username=<?php echo $commUserName?>"><?php echo $commUserName . ":";?></a> <p><?php echo $comment['comm']; ?></p></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
              <div class="row g-2">
                <div class="col-md-10">
                  <div class="form-floating">
                    <input type="hidden" name="postId" value="<?php echo $post['postId'] ?>">
                    <textarea class="form-control" placeholder="Leave a comment here" id="commentTextArea<?php echo $post['postId'];?>" name="comment" required></textarea>
                    <label for="commentTextArea<?php echo $post['postId'];?>">Comments</label>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-floating">
                    <button class ="btn addCommentBtn" data-post-id="<?php echo $post['postId'];?>">Add</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <script src="script/post.js"></script>
</main>