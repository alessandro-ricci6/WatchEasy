<?php

require_once 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $_POST = json_decode($jsonData, true);

    if(isset($_POST['action'])) {
        if($_POST['action'] == "readAll") {
            $db->readAllNotification(3);
            echo json_encode(array('notificationCounter' => mysqli_num_rows($db->getActiveNotification(3))));
        }
        elseif ($_POST['action'] == 'readOne' && isset($_POST['notificationId'])) {
            $db->readNotification($_POST['notificationId']);
            echo json_encode(array('notificationCounter' => mysqli_num_rows($db->getActiveNotification(3))));
        }
    }
}

?>