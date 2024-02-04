<?php

require_once 'bootstrap.php';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);

$templateParams['titolo'] = 'WatchEasy - Profilo';
$templateParams['nome'] = 'profile_page.php';
$templateParams['username'] = $db->getUserName($userId);
$templateParams['post'] = $db->getPostByUserId($userId);
$templateParams['numpost'] = $db->getNumberOfPost($userId);
$templateParams['follower'] = $db->getNumberOfFollower($userId);
$templateParams['followed'] = $db->getNumberOfFollowed($userId);
$templateParams['show'] = $db->getShowByUserId($userId);
$templateParams['totepisode'] = $db->getViewedEpisodeNumber($userId);

require 'template/base.php'




?>