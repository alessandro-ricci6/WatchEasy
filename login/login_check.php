<?php
include '../bootstrap.php';
require_once("functions.php");

if(login_check($db->getMysqli()) == true) {

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch ($page) {
            case 'feed':
                $_SESSION['current_page'] = '../feed_page.php?username=' . $_SESSION['username'];
                break;
            case 'profile':
                $_SESSION['current_page'] = '../profile.php?username=' . $_SESSION['username'];
                break;
        }
    }
    $redirect_page = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 'login.php';
    
    unset($_SESSION['current_page']);
    
    header("Location: $redirect_page");
    exit();
} else {
    echo 'You are not authorized to access this page, please login. <br/>';
    header("Location: ./login.php?notLogged=you are not logged");
    exit();
} 
?>