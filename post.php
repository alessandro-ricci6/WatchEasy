<?php

require_once 'bootstrap.php';

ini_set('display_errors',1);

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $_POST = json_decode($jsonData, true);

    if (isset($_POST['action'], $_POST['postId'], $_POST['creatorId'])){
        $action = $_POST['action'];
        $postId = $_POST['postId'];
        $creatorId = $_POST['creatorId'];

        if($action == "like") {
            $db->userLikePost($userId, $postId);
            $db->addNotification($userId, $creatorId, 2, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "unlike") {
            $db->userUnlikePost($userId, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "comment" && isset($_POST['commentText'])) {
            $db->addComment($postId, $userId, $_POST['commentText']);
            $db->addNotification($userId, $creatorId, 3, $postId);
            $response = [
                "username" => $db->getUserName($userId),
                "numComment" => count($db->getComments($postId))
            ];
            echo json_encode($response);
        } else if ($action == "delete"){
            $db->deletePost($postId);
            $img = $db->getPostById($postId)['img'];
            deleteImage($img);
        } else if($action == "reply" && isset($_POST['replyText'], $_POST['commentId'])){
            $db->addReply($_POST['commentId'], $userId, $_POST['replyText']);
            $db->addNotification($userId, $creatorId, 3, $postId);
            $response = [
                "username" => $db->getUserName($userId)
            ];
            echo json_encode($response);
        }
    } else if(isset($_POST['action'], $_POST['postId']) && $_POST['action'] == 'delete') {
        $img = $db->getPostById($_POST['postId'])['postImg'];
        deleteImage($img);
        $db->deletePost($_POST['postId']);
    }
}

?>