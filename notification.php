<?php

require_once 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if(isset($data['action'])) {
        if($data['action'] == "readAll") {
            $db->readAllNotification(3);
        }
    }
}

?>