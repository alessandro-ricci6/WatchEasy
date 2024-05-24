<?php

function searchShow() {
    if(isset($_GET['search-input']) ){
        $search = $_GET['search-input'];
        $url = 'https://api.tvmaze.com/search/shows?q=' . $search;
        $response = file_get_contents($url);
        $data = json_decode($response,true);
        if ($data) {
            $seriesTitle = $data["name"];
            $seriesSummary = $data["summary"];
        
            $seasonsURL = "https://api.tvmaze.com/shows/" . $data["id"] . "/seasons";
            $seasonsResponse = file_get_contents($seasonsURL);
            $seasonsData = json_decode($seasonsResponse, true);
                echo $seriesTitle;
                echo $seriesSummary;
                
            
        
        } else {
            echo "Errore nella richiesta a TVmaze";
        }

        
    } else {
        echo "Questa serie non esiste";
    }

    return $url;
    
}




?>