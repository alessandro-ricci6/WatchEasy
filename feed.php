<?php

require_once 'bootstrap.php';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);


$templateParams['titolo'] = 'WatchEasy - Feed';
$templateParams['nome'] = 'lista-post.php';
$templateParams['post'] = $db->getPostByShow($userId);

require 'template/base.php';

?>