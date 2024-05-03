<?php
require_once '../bootstrap.php';
require_once("functions.php");
function emailExists($email, $db) {
    $query = "SELECT userId FROM users WHERE email = ?";
    if ($stmt = $db->getMysqli()->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    } else {
        return false;
    }
}

$password = $_POST['p'];
$original_pass = $password;
$username = $_POST['username'];
$email = $_POST['email'];

if (emailExists($email, $db)) {
    header("Location: register.html?error=email_exists");
    exit();
}

$password = password_hash($password, PASSWORD_BCRYPT);

if ($insert_stmt = $db->getMysqli()->prepare("INSERT INTO users (username, email, pass) VALUES (?, ?, ?)")) {    
   $insert_stmt->bind_param('sss', $username, $email, $password); 
   $insert_stmt->execute();
   $insert_stmt->close();
   if(login($email, $original_pass, $db->getMysqli())){
    if(login_check($db->getMysqli())){
        header("Location: ../index.php");
        return true;
    }else{
        return false;
    }
   }else{
    return false;
   }
} else {
    return false;
}

?>