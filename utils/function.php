<?php

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

?>