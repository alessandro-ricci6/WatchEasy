<?php
require_once 'bootstrap.php';
$showId = 0;

if (isset($_GET['showId'])) {
    $showId = $_GET['showId'];
}

if ($showId != 0) {
    $mainInfo = $api->getTvShowById($showId);

    $templateParams['nome'] = 'template/show.php';
    $templateParams['titolo'] = 'WatchEasy - ' . $mainInfo['name'];

    $templateParams['showSaved'] = $db->getShowByUser($_SESSION['user_id']);
    $templateParams['epSaved'] = $db->getSavedEpisode($_SESSION['user_id']);
    $templateParams['showName'] = $mainInfo['name'];
    $templateParams['showId'] = $showId;
    $templateParams['summary'] = $mainInfo['summary'];
    $templateParams['showImg'] = $mainInfo['image']['original'];
    $templateParams['seasonNumber'] = $api->getNumberOfSeason($showId);

    foreach ($templateParams['seasonNumber'] as $season) {
        $templateParams['season' . $season['number']] = $api->getNumberOfEpisodes($season['id']);
    }

    require 'template/base.php';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data['action'] == 'saveShow' && isset($data['showId'])) {
        $db->saveShow($data['showId'], $_SESSION['user_id']);
    } else if ($data['action'] == 'delShow' && isset($data['showId'])) {
        $db->deleteShow($data['showId'], $_SESSION['user_id']);
    } else if ($data['action'] == 'saveEpisode' && isset($data['epId'])) {
        $db->saveEpisode($data['epId'], $_SESSION['user_id']);
    } else if ($data['action'] == 'delEpisode' && isset($data['epId'])) {
        $db->deleteEpisode($data['epId'], $_SESSION['user_id']);
    }
}