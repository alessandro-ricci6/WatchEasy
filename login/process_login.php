<?php

include 'db_connect.php';
include 'functions.php';

safe_session_start();
if(isset($_POST['email'], $_POST['p'])) {
   $email = $_POST['email'];
   $password = $_POST['p'];
   if(login($email, $password, $mysqli) == true) {
      $_SESSION['home_page'] = '../index.php';
      header('Location: login_check.php');
      echo 'Success: You have been logged in!';
   } else {
      echo 'porco giuda';
      header('Location: ./login.php?error=password or email does not exist');
   }
} else { 
   var_dump($email);
   echo 'Invalid Request';
}

?>