<?php

class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
    }

    public function getPost($userId){
        $stmt = $this->db->prepare("SELECT * FROM post JOIN user ON post.userId = user.userId JOIN follow ON post.userId = follow.toUserId WHERE follow.fromUserId = ? ORDER BY pubTime DESC");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserName($userId) {
        $stmt = $this->db->prepare("SELECT username FROM user WHERE userId = ?");
        $stmt->bind_param('s', $userId);
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
        $stmt = $this->db->prepare("SELECT * FROM user WHERE username LIKE ?");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getNotificationByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notification WHERE toUserId = ?");
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
}

?>