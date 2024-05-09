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
/*
$templateParams['nome'] = 'lista-post.php';
$templateParams['post'] = $db->getPostByShow($userId);
*/

function searchShow() {
    if(isset($_GET['search-input']) && !empty(isset($_GET['search-input']))){
        $search = $_GET['search-input'];
        $url = 'https://api.tvmaze.com/search/shows?q=' .$search;
        $response = file_get_contents($url);
        $data = json_decode($response,true);


        
    } else {
        echo "Questa serie non esiste";
    }
    
    if($data){
            $seriesTitle = $data["name"];
            $seriesId = $data["id"];
        } else {
            echo "errore nella richiesta per TVMaze";
        }
        echo $url;

    }
    

    



require 'template/base.php';

?>
