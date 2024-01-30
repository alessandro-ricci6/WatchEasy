<?php

require_once 'bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (isset($data['action'], $data['postId'])){
        $action = $data['action'];
        $postId = $data['postId'];

        if($action == "like") {
            $db->userLikePost(3, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "unlike") {
            $db->userUnlikePost(3, $postId);
            echo $db->getLikeNumber($postId);
        } else if($action == "comment" && isset($data['commentText'])) {
            $db->addComment($postId, 3, $data['commentText']);
            $response = [
                "username" => $db->getUserName(3),
                "numComment" => count($db->getComments($postId))
            ];
            echo json_encode($response);
        }

        
        
    }
}

?>