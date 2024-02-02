<?php

require_once 'bootstrap.php';

ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $_POST = json_decode($jsonData, true);

    if (isset($_POST['action'], $_POST['postId'])){
        $action = $_POST['action'];
        $postId = $_POST['postId'];

        if($action == "like") {
            $db->userLikePost(3, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "unlike") {
            $db->userUnlikePost(3, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "comment" && isset($_POST['commentText'])) {
            $db->addComment($postId, 3, $_POST['commentText']);
            $response = [
                "username" => $db->getUserName(3),
                "numComment" => count($db->getComments($postId))
            ];
            echo json_encode($response);
        } else if ($action == "delete"){
            $db->deletePost($postId);
        }

        
        
    }
}

?>