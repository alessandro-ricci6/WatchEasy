<?php
include 'db_connect.php';
include 'functions.php';
function emailExists($email, $mysqli) {
    $query = "SELECT userId FROM users WHERE email = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    } else {
        return false;
    }
}

$password = $_POST['p'];
$username = $_POST['username'];
$email = $_POST['email'];

if (emailExists($email, $mysqli)) {
    header("Location: register.html?error=email_exists");
    exit();
}

$password = password_hash($password, PASSWORD_BCRYPT);

if ($insert_stmt = $mysqli->prepare("INSERT INTO users (username, email, pass) VALUES (?, ?, ?)")) {    
   $insert_stmt->bind_param('sss', $username, $email, $password); 
   $insert_stmt->execute();
   $insert_stmt->close();
   safe_session_start();
   login($email, $password, $mysqli);
   login_check($mysqli);
   header("Location: ../index.php");
   return true;
} else {
    return false;
}

?>