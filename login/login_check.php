<?php
include 'db_connect.php';
include 'functions.php';

safe_session_start();
if(login_check($mysqli) == true) {
    $redirect_page = isset($_SESSION['home_page']) ? $_SESSION['home_page'] : 'login.php';
    
    unset($_SESSION['home_page']);
    
    header("Location: $redirect_page");
    exit();
} else {
   echo 'You are not authorized to access this page, please login. <br/>';
}
?>