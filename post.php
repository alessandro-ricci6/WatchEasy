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
        } else if($action == "unlike") {
            $db->userUnlikePost(3, $postId);
        }

        $newLikeNumber = $db->getLikeNumber($postId);

        echo $newLikeNumber;
    }
}

?>