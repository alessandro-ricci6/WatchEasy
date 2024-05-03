<?php
require_once 'bootstrap.php';
ini_set('display_errors',1 );

if(!isset($_SESSION['user_id'])) {
    header("Location: ./login/login_check.php");
} else {
    $templateParams['titolo'] = 'WatchEasy - Home';
    $templateParams['nome'] = 'home.php';
    $templateParams['post'] = $db->getPostOfFollowing($_SESSION['user_id']);

    require 'template/base.php';
}

?>