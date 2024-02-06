<?php

require_once '../bootstrap.php';
require_once("functions.php");

if(isset($_POST['email'], $_POST['p'])) {
   $email = $_POST['email'];
   $password = $_POST['p'];
   if(login($email, $password, $db->getMysqli()) == true) {
      
      $redirect_page = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : '../index.php';
      unset($_SESSION['current_page']);
      header("Location: $redirect_page");
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