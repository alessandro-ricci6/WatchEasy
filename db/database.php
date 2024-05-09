<?php
class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
    }

    public function getMysqli(){
        return $this->db;
    }

    public function getPostOfFollowing($userId){
        $stmt = $this->db->prepare("SELECT * FROM post JOIN users ON post.userId = users.userId JOIN follow ON post.userId = follow.toUserId WHERE follow.fromUserId = ? ORDER BY pubTime DESC");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostOfSeriesById($showId){
        $stmt = $this->db->prepare("SELECT * FROM post JOIN users ON post.userId = users.userId WHERE post.showId = ? ORDER BY pubTime DESC");
        $stmt->bind_param('i', $showId);
        $stmt->execute();
        $result = $stmt->get_result(); 

        return $result->fetch_all(MYSQLI_ASSOC);
    
    }

    public function getUserIdByName($username) {
        $stmt = $this->db->prepare("SELECT userId FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0]['userId'];
    }

    public function getPostById($postId) {
        $stmt = $this->db->prepare("SELECT * FROM post WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE userId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function getUserName($userId) {
        $stmt = $this->db->prepare("SELECT username FROM users WHERE userId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC)[0]['username'];
    }

    public function getLikeNumber($postId){
        $stmt = $this->db->prepare("SELECT * FROM likes WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all(MYSQLI_ASSOC));
    }

    public function getComments($postId){
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchUser($query){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username LIKE '%$query%'");
        //$stmt->bind_param("s", $query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getNotificationByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notification WHERE toUserId = ? ORDER BY notificationTime DESC LIMIT 10");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getActiveNotification($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notification WHERE toUserId = ? AND notificationRead = 0");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function readNotification($notId) {
        $stmt = $this->db->prepare("UPDATE notification SET notificationRead = 1 WHERE notificationId = ?");
        $stmt->bind_param('i', $notId);
        $stmt->execute();
    }

    public function readAllNotification($userId) {
        $stmt = $this->db->prepare("UPDATE notification SET notificationRead = 1 WHERE toUserId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }

    public function getNotificationStatus($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notification WHERE toUserId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return json_encode($result->fetch_all(MYSQLI_ASSOC));
    }

    public function addComment($postId, $userId, $comment) {
        $stmt = $this->db->prepare("INSERT INTO comments (postId, userId, comm) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $postId, $userId, $comment);
        $stmt->execute();
    }

    public function userLikePost($userId, $postId) {
        $stmt = $this->db->prepare("INSERT INTO likes (userId, postId) VALUES (?, ?)");
        $stmt->bind_param('ii', $userId, $postId);
        $stmt->execute();
    }

    public function userUnlikePost($userId, $postId) {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE postId = ? AND userId = ?");
        $stmt->bind_param('ii', $postId, $userId);
        $stmt->execute();
    }

    public function getLikedPost($userId, $postId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM likes WHERE userId = ? AND postId = ?");
        $stmt->bind_param('ii', $userId, $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = mysqli_fetch_assoc($result);
        $count = intval($row['count']);

        if ($count == 0) {
            echo 'fa-regular fa-heart';
        } else {
            echo 'fa-solid fa-heart';
        }
    }

    public function getShowByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM showSaved WHERE userId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createPost($userId, $showId, $img, $comment) {
        $stmt = $this->db->prepare("INSERT INTO post (userId, showId, postImg, paragraph) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $userId, $showId, $img, $comment);
        $stmt->execute();
    }

    public function deleteButtonDisable($postId) {
        $post = $this->getPostById($postId);
        if ($post['userId'] == $_SESSION['user_id']){
            echo "";
        } else {
            echo "disabled";
        }
    }

    private function deleteLikesOfPost($postId){
        $stmt = $this->db->prepare("DELETE FROM likes WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
    }

    private function deleteReplyOfComment($commentId) {
        $stmt = $this->db->prepare("DELETE FROM commentReply WHERE commentId = ?");
        $stmt->bind_param('i', $commentId);
        $stmt->execute();  
    }

    private function deleteCommentsOfPost($postId) {
        $query = $this->db->prepare("SELECT * FROM comments WHERE postId = ?");
        $query->bind_param('i', $postId);
        $query->execute();
        $result = $query->get_result();
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $comment) {
            $this->deleteReplyOfComment($comment['commentId']);
        }
        $stmt = $this->db->prepare("DELETE FROM comments WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();  
    }

    private function deleteNotificationOfPost($postId) {
        $stmt = $this->db->prepare("DELETE FROM notification WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();  
    }

    public function deletePost($postId) {
        $this->deleteNotificationOfPost($postId);
        $this->deleteLikesOfPost($postId);
        $this->deleteCommentsOfPost($postId);
        $stmt = $this->db->prepare("DELETE FROM post WHERE postId = ?");
        $stmt->bind_param('i', $postId);
        $stmt->execute();
    }

    function getNumberOfPost($userId){

        $stmt = $this->db->prepare("SELECT * FROM post WHERE userId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return mysqli_num_rows($stmt->get_result());

    }

    function getNumberOfFollower($userId){

        $stmt = $this->db->prepare("SELECT * FROM follow WHERE toUserId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return mysqli_num_rows($stmt->get_result());


    }

    function getNumberOfFollowed($userId){

        $stmt = $this->db->prepare("SELECT * FROM follow WHERE fromUserId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return mysqli_num_rows($stmt->get_result());

    }

    function getShowByUserId($userId){

        $stmt = $this->db->prepare("SELECT * FROM showSaved WHERE userId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    //num episodi visti
    function getViewedEpisodeNumber($userId){
        $stmt = $this->db->prepare("SELECT * FROM episodeSaved WHERE userId = ?");
          $stmt->bind_param('i', $userId);
          $stmt->execute();

          return mysqli_num_rows($stmt->get_result());

    }

    
    function getShowById($userId) {

        $stmt = $this->db->prepare("SELECT showid FROM showSaved WHERE userid = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function addFollower($userId, $visited){
        $stmt = $this->db->prepare("INSERT INTO follow (fromUserid, toUserid) VALUES (?, ?)");
        $stmt->bind_param('ii', $userId, $visited);
        $stmt->execute();

    }

    public function addNotification($fromUserId, $toUserId, $type, $postId) {
        $stmt = $this->db->prepare("INSERT INTO notification (fromUserId, toUserId, notificationType, postId)  VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiii', $fromUserId, $toUserId, $type, $postId);
        $stmt->execute();
    }

    public function addFollowNotification($fromUserId, $toUserId) {
        $stmt = $this->db->prepare("INSERT INTO notification (fromUserId, toUserId, notificationType)  VALUES (?, ?, 1)");
        $stmt->bind_param('ii', $fromUserId, $toUserId);
        $stmt->execute();
    }

    public function getPostByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM post WHERE userId = ? ORDER BY pubTime DESC");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCommentReply($commentId) {
        $stmt = $this->db->prepare("SELECT * FROM commentReply WHERE commentId = ?");
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addReply($commentId, $userId, $paragraph) {
        $stmt = $this->db->prepare("INSERT INTO commentReply (commentId, userId, paragraph) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $commentId, $userId, $paragraph);
        $stmt->execute();
    }

    public function getPostBySavedId($saveId){
        $stmt = $this->db->prepare("SELECT * FROM post WHERE showId = ?");
        $stmt->bind_param('i', $savedId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    /*public function getPostByShow($userId){
        $stmt = $this->db->prepare("SELECT * FROM post join showSaved on post.userId = showSaved.userId WHERE userId = $userId");
        $stmt->bind_param('i', $savedId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);

    }
    */
    public function getPostNotSaved($userId){
        $stmt = $this->db->prepare("SELECT p.postId, p.userId,p.content, p.createAt FROM Post p
            LEFT JOIN Follow f ON p.userId = f.toUserId AND f.fromUserId = ? WHERE f.fromuserId IS NULL");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>