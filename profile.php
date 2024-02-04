<?php

require_once 'bootstrap.php';

$userId = 0;
ini_set("display_errors", 1);

if(isset($_GET["userId"])){
    $userId = $_GET["userId"];
}

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