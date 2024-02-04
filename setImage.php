<?php

require_once 'bootstrap.php';
require 'profile.php';


//da dove lo recupero lo showID
$userId = $_GET["id"];

$showId = $db->getShowById($userId);

foreach($showId as $saved) {
    $showURL = "https://api.tvmaze.com/shows/" . $showId;

$response = file_get_contents($showURL);

$show = json_decode($response, true);

if ($show) {
    // Itera attraverso l'array delle serie TV
    foreach ($show as $serie) {
        // Ottieni l'URL dell'immagine della serie TV
        $image = $serie['image']['medium'];

        // Stampare l'immagine nella pagina HTML
        echo '<img src="' . $image . '" alt=">';
    }
} else {
    echo 'Error';
}
}


?>