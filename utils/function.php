<?php

require 'bootstrap.php';

function isActive($pagename){
    if(basename($_SERVER['PHP_SELF'])==$pagename){
        echo " class='active' ";
    }
}

function getNotificationType($notificationType) {
    switch ($notificationType) {
        case '1':
            echo " ha iniziato a seguirti";
            break;
        case '2':
            echo " ha messo mi piace al";
            break;
        case '3':
            echo " ha commentato il";
            break;
    }
}

function notificationStyle($read) {
    if ($read == 1) {
        echo "list-group-item-secondary";
    } else {
        echo "";
    }
}

function uploadImage($image) {
    $name = pathinfo($image['name'], PATHINFO_FILENAME);
    $index = 1;
    $ext = pathinfo($image['name'])['extension'];

    if ($image['size'] > 500*1024) {
        echo "Dimensioni immagine troppo grande (MAX 500Kb).";
    }

    if (!$ext == 'png' || !$ext == 'jpeg' || !$ext == 'jpg'){
        echo "Formato non corretto (Formati accettati: jpg, png, jpeg).";
    }

    while (file_exists(POSTIMGDIR . $name . $index . $ext)){
        $index += 1;
    }

    $destination = POSTIMGDIR . $name . $index . $ext;

    if(move_uploaded_file($image['tmp_name'], $destination)) {
        echo 'Caricamento immagine eseguito';
        return $name . $index . $ext;
    } else {
        echo "Errore durante il caricamento dell'immagine";
    }
}

?>