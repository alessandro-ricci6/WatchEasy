<?php

require 'bootstrap.php';
// Check connection

if($_SESSION['userId']) {
    $userId = $_SESSION['userId'];

    } else {
        die("Errore: Utente non autenticato o ID utente non valido.");
    }
    

    if(isset($_GET['visit']) && !empty($_GET['visit'])) {
        $followId = $_GET['visit'];
    
    $db->addFollower($userId,$followId);
    $db->addFollowNotification($userId,$followId);

    }
    
   