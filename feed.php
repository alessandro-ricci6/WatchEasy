<?php

require_once 'bootstrap.php';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);
$showId = $db->getShowById($userId);


$templateParams['titolo'] = 'WatchEasy - Feed';
$templateParams['nome'] = 'feed.php';
$templateParams['post'] = $db->getPostBySavedId($showId);

require 'template/base.php';

?>