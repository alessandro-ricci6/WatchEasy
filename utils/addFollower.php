<?php

require 'bootstrap.php';
// Check connection
if($_SESSION['userId']) {
    $userId = $_SESSION['userId'];

    }
    $followId = $_GET['visit'];

$query = "INSERT INTO follow (fromUserid, toUserid) VALUES (?, ?)";
$stmt->bind_param('ii', $userId, $visited);
$stmt->execute();