<?php

require_once 'bootstrap.php';

$templateParams['titolo'] = 'WatchEasy - Post';
$templateParams['nome'] = 'singolo-post.php';
$postId = -1;

if(isset($_GET['postId'])){
    $postId = $_GET['postId'];
}

$templateParams['post'] = $db->getPostById($postId);

require_once 'template/base.php';

?>