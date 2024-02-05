<?php

require_once 'bootstrap.php';

$userId = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['action'])) {
        if($_GET['action'] == 'updateNotification'){
            $notification = $db->getNotificationByUserId($userId);
            $data = array('notificationNumber' => mysqli_num_rows($db->getActiveNotification($userId)),
            'notification' => $notification);
            echo json_encode($data);
        } else if ($_GET['action'] == 'getUsername' && isset($_GET['userId'])) {
            $username = $db->getUserName($_GET['userId']);
            $data = array('username' => $username);
            echo json_encode($data);
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonData = file_get_contents('php://input');
    $_POST = json_decode($jsonData, true);

    if(isset($_POST['action'])) {
        if($_POST['action'] == "readAll") {
            $db->readAllNotification($userId);
            echo json_encode(array('notificationCounter' => mysqli_num_rows($db->getActiveNotification($userId))));
        }
        elseif ($_POST['action'] == 'readOne' && isset($_POST['notificationId'])) {
            $db->readNotification($_POST['notificationId']);
            echo json_encode(array('notificationCounter' => mysqli_num_rows($db->getActiveNotification($userId))));
        }
    }
}

?>