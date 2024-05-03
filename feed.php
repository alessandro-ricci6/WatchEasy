<?php

require_once 'bootstrap.php';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);
$showId = $db->getShowById($userId);


if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);


$templateParams['titolo'] = 'WatchEasy - Feed';
$templateParams['nome'] = 'feed.php';
$templateParams['post'] = $db->getPostBySavedId($showId);
$templateParams['nome'] = 'lista-post.php';
$templateParams['post'] = $db->getPostByShow($userId);

require 'template/base.php';

?>