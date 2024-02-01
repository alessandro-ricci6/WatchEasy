
<div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Notification</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul class="list-group notificationList" id="notificationList">
            <?php foreach ($db->getNotificationByUserId(3) as $notification):
                $fromUsername = $db->getUserName($notification['fromUserId']);
                if ($notification['notificationRead'] == 1):?>
                <li id="notification<?php echo $notification['notificationId'];?>" class="notification list-group-item border list-group-item-secondary"><a href="profile.php?username?<?php echo $fromUsername; ?>"><?php echo $fromUsername;?></a><?php getNotificationType($notification['notificationType']);
                if($notification['postId'] != null){
                  echo "<a href='post-detail.php?postId=" . $notification['postId'] ."'> tuo post</a>";
                }
                ?></li>
                <?php else:?>
                <li id="notification<?php echo $notification['notificationId'];?>" class="notification list-group-item border"><a href="profile.php?username?<?php echo $fromUsername; ?>"><?php echo $fromUsername;?></a><?php getNotificationType($notification['notificationType']);
                if($notification['postId'] != null){
                  echo "<a href='post-detail.php?postId=" . $notification['postId'] ."'> tuo post</a>";
                }
                ?></li>
            <?php endif;
            endforeach; ?>
            </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="readAllNotificationBtn">Read All</button>
        </div>

        </div>
      </div>
      <script src="script/notification.js"></script>
