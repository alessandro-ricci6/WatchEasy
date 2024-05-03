<?php

require 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['showSelect'], $_POST['comment'])){
    $userId = $_SESSION['user_id'];
    $showId = (int) $_POST['showSelect'];
    $fileName = null;
    if(isset($_FILES['uploadImg'])){
        $fileName = uploadImage($_FILES['uploadImg']);       
    }

    $comment = $_POST['comment'];

    $db->createPost($userId, $showId, $fileName, $comment);
}

?>