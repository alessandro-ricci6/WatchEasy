<?php

require_once 'bootstrap.php';


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $_POST = json_decode($jsonData, true);

    if (isset($_POST['action'], $_POST['postId'], $_POST['creatorId'])){
        $action = $_POST['action'];
        $postId = $_POST['postId'];
        $creatorId = $_POST['creatorId'];

        if($action == "like") {
            $db->userLikePost(3, $postId);
            $db->addNotification(3, $creatorId, 2, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "unlike") {
            $db->userUnlikePost(3, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "comment" && isset($_POST['commentText'])) {
            $db->addComment($postId, 3, $_POST['commentText']);
            $db->addNotification(3, $creatorId, 3, $postId);
            $response = [
                "username" => $db->getUserName(3),
                "numComment" => count($db->getComments($postId))
            ];
            echo json_encode($response);
        } else if ($action == "delete"){
            $db->deletePost($postId);
            $img = $db->getPostById($postId)['img'];
            deleteImage($img);
        } else if($action == "reply" && isset($_POST['replyText'], $_POST['commentId'])){
            $db->addReply($_POST['commentId'], 3, $_POST['replyText']);
            $db->addNotification(3, $creatorId, 3, $postId);
            $response = [
                "username" => $db->getUserName(3)
            ];
            echo json_encode($response);
        }
    }
}

?>