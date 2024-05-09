<?php

require_once 'bootstrap.php';
include 'template/profile_page.php';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);

if($_SESSION['userId']) {
    $userId = $_SESSION['userId'];
    $visit = $db->getUserIdByName($username);
    $templateParams['visit'] = $visit;
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