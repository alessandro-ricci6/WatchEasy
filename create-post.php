<?php

require 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userId = 3;
    $showId = (int) $_POST['showSelect'];
    $seasonId = null;
    $episodeId = null;
    $fileName = null;
    if(isset($_POST['seasonSelect'])){
        $seasonId = (int) $_POST['seasonSelect'];
    }
    if(isset($_POST['episodeSelect'])){
        $episodeId = (int) $_POST['episodeSelect'];
    }
    if(isset($_FILES['uploadImg'])){
        $fileName = uploadImage($_FILES['uploadImg']);       
    }

    $comment = $_POST['comment'];

    $db->createPost($userId, $showId, $seasonId, $episodeId, $fileName, $comment);
}

?>