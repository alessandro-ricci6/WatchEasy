<?php
//require_once '../bootstrap.php';
require_once("functions.php");

if(login_check($db->getMysqli()) == true) {
    $redirect_page = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 'login.php';
    
    unset($_SESSION['current_page']);
    
    header("Location: $redirect_page");
    exit();
} else {
    echo 'You are not authorized to access this page, please login. <br/>';
    header("Location: login/login.php?notLogged=you are not logged");
    exit();
} 
?>