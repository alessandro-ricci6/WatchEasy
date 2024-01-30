<div class="d-flex flex-column justify-content-center mx-3">
<?php
foreach ($templateParams['post'] as $post): 
    $show = $api->getTvShowById($post['showId']);
    $userName = $db->getUserName($post['userId'])?>
    <div class="card my-3">
      <?php if ($post['img'] != null):
        ?>
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
          <a href="#"
            ><i class="fa-solid fa-circle-user"></i> <?php echo $userName['username']?></a>
        </h6>
        <p class="card-text"><?php echo $post['paragraph']; ?>
        </p>
        <button class="btn likeBtn" data-post-id="<?php echo $post['postId'] ?>"><span class="likeNumber"><?php echo $db->getLikeNumber($post['postId']); ?> </span><i class="<?php $db->getLikedPost(3, $post['postId']) ?>"></i></button>
        <button
          class="btn"
          data-bs-toggle="collapse"
          data-bs-target="#comments-collapse<?php echo $post['postId'] ?>"
        >
          <?php $comments = $db->getComments($post['postId']);
          echo count($comments); ?> <i class="fa-regular fa-comment"></i>
        </button>
        <div id="comments-collapse<?php echo $post['postId']; ?>" class="collapse">
          <ul id="commentList">
              <?php foreach ($comments as $comment):
                $commUserName = $db->getUserName($comment['userID'])?>
            <li><a href="#"><?php echo $commUserName['username'] . ":";?></a> <p><?php echo $comment['comm']; ?></p></li>
              <?php endforeach; ?>
          </ul>
          <div class="row g-2">
            <form id="commentForm">
              <div class="col-md-10">
                <div class="form-floating">
                  <input type="hidden" name="postId" value="<?php echo $post['postId'] ?>">
                  <textarea class="form-control" placeholder="Leave a comment here" id="commentTextArea" name="comment" required></textarea>
                  <label for="floatingTextarea2">Comments</label>
                </div>
              </div>
              <div class="col-md-1">
                <div class="form-floating">
                  <input class ="btn" type="submit" value="Add" id="addCommentBtn">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>
</div>
