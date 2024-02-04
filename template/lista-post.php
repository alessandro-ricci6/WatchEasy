<main class="float-md-start col-md-8">
<div class="d-flex flex-column justify-content-center mx-3" id="postContainer">
<?php
foreach ($templateParams['post'] as $post): 
    $show = $api->getTvShowById($post['showId']);
    $userName = $db->getUserName($post['userId'])?>
    <div class="card my-3" id="cardPost<?php echo $post['postId'] ?>">
      <?php if ($post['postImg'] != null):
        ?>
        <img class="py-1 mx-auto col-10" src="<?php echo POSTIMGDIR . $post['postImg']; ?>" alt="">
      <?php endif; ?>
      <div class="card-body">
      <a class="float-end btn popoverPost" tabindex="0" role="button" data-post-id="<?php echo $post['postId']?>"
      data-toggle="popover" data-bs-trigger="focus" data-bs-placement="bottom" data-bs-html="true" 
      data-bs-content="<div class='d-flex justify-content-center'>
      <a class='btn <?php $db->deleteButtonDisable($post['postId']);?> text-danger deleteBtn'>Delete</a></div>">
      <span class="fa-solid fa-ellipsis-vertical"></span></a>
        <h5 class="card-title"><a href="show.php?showId=<?php echo $post['showId'] ?>"><?php echo $show['name'];
        if ($post['seasonId'] != null && $post['episodeId'] != null){
          echo " S: " . $post['seasonId'] . "/E: " . $post['episodeId'];
        } elseif($post['seasonId'] != null && $post['episodeId'] == null) {
          echo " S: " . $post['seasonId'];
        }
        ?></a></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">
          <a href="profile.php?username=<?php echo $userName ?>"
            ><i class="fa-solid fa-circle-user"></i> <?php echo $userName?></a>
        </h6>
        <p class="card-text"><?php echo $post['paragraph']; ?>
        </p>
        <button class="btn likeBtn" data-post-id="<?php echo $post['postId'] ?>" data-creator-id="<?php echo $post['userId']?>"><span class="likeNumber"><?php echo $db->getLikeNumber($post['postId']); ?> </span><span class="likeIcon <?php $db->getLikedPost(3, $post['postId']) ?>"></span></button>
        <button
          class="btn"
          id="commentBtn<?php echo $post['postId']?>"
          data-bs-toggle="collapse"
          data-bs-target="#comments-collapse<?php echo $post['postId'] ?>"
        >
          <?php $comments = $db->getComments($post['postId']);
          echo count($comments); ?> <i class="fa-regular fa-comment"></i>
        </button>
        <div id="comments-collapse<?php echo $post['postId']; ?>" class="collapse">
          <div class="commentDiv overflow-auto" style="max-height:150px">
            <ul class="list-unstyled px-3" id="commentList<?php echo $post['postId'];?>">
              <?php foreach ($comments as $comment):
                  $commUserName = $db->getUserName($comment['userId'])?>
              <li id="comment<?php echo $comment['commentId']?>"><a href="profile.php?username=<?php echo $commUserName?>"><?php echo $commUserName . ":";?></a> <p><?php echo $comment['comm']; ?></p></li>
                  <a class="commentAnswerOpen px-2 py-1" data-bs-toggle="collapse" href="#commentAnswer<?php echo $comment['commentId']?>"
                  role="button" aria-expanded="false" aria-controls="commentAnswer<?php echo $comment['commentId']?>"
                  >Vedi risposte</a>
                  <div class="collapse border-bottom" id="commentAnswer<?php echo $comment['commentId']?>">
                    <div>  
                      <ul class="list-unstyled px-2" id="replyList<?php echo $comment['commentId']?>">
                        <?php $commentreply = $db->getCommentReply($comment['commentId']);
                        foreach ($commentreply as $reply):
                        $replyUsername = $db->getUserName($reply['userId'])?>
                          <li id="commentReply<?php echo $reply['commentReplyId']?>"><a href="profile.php?username=<?php echo $replyUsername?>">
                          <?php echo $replyUsername . ': '?></a>
                          <p><?php echo $reply['paragraph'] ?></</p>
                        </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <div class="row g-2">
                      <div class="col-md-10">
                        <div class="form-floating">
                          <input type="hidden" name="commentId" value="<?php echo $comment['commentId'] ?>">
                          <textarea class="form-control" placeholder="Leave a reply here" id="replyTextArea<?php echo $comment['commentId']?>" name="reply" required></textarea>
                          <label for="replyTextArea<?php echo $comment['commentId'];?>">Reply</label>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-floating">
                          <button class="btn addReplyBtn" data-comment-id="<?php echo $comment['commentId'] ?>" data-post-id="<?php echo $post['postId']?>" data-creator-id="<?php echo $comment['userId']?>">Add</button>
                        </div>
                      </div>
                    </div>
                  </div>
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
                <button class="btn addCommentBtn" data-post-id="<?php echo $post['postId'] ?>" data-creator-id="<?php echo $post['userId']?>">Add</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>
</div>
    <script src="script/post.js"></script>
    <script src="script/home.js"></script>
</main>
