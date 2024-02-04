<?php

require_once 'bootstrap.php';

$userId = 0;

if(isset($_GET ["id"])){
    $userId = $_GET["id"];
}

$templateParams['titolo'] = 'WatchEasy - Profilo';
$templateParams['nome'] = 'profile.php';
$templateParams['username'] = $db->getUserName($userId);
//$templateParams['post'] 
$templateParams['numpost'] = $db->getNumberOfPost($userId);
$templateParams['follower'] = $db->getNumberOfFollower($userId);
$templateParams['followed'] = $db->getNumberOfFollowed($userId);
$templateParams['show'] = $db->getNumberOfViewedSeries($userId);
$templateParams['totepisode'] = $db->getViewedEpisode($userId);

require 'template/base.php'




?>