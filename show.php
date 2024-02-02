<?php

require 'bootstrap.php';

if (isset($_GET['action'])){
    if($_GET['action'] == 'getSeason' && isset($_GET['showId'])) {
        $seasons = $api->getNumberOfSeason($_GET['showId']);
        $jsonArray = array();
        foreach ($seasons as $season) {
            array_push($jsonArray, array('seasonNumber' => $season['number'], 'seasonId' => $season['id']));
        }
        echo json_encode($jsonArray);
    }
    elseif($_GET['action'] == 'getEpisode' && isset($_GET['seasonId'])) {
        $seasons = $api->getNumberOfEpisodes($_GET['seasonId']);
        $jsonArray = array();
        foreach ($seasons as $season) {
            array_push($jsonArray, array('episodeNumber' => $season['number'], 'episodeId' => $season['id']));
        }
        echo json_encode($jsonArray);
    }
}

?>