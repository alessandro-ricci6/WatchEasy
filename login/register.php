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
$img = "default.png";

if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../" . PROFILEPICDIR;
    $imageFileType = strtolower(pathinfo($_FILES["profilePic"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . "." . $imageFileType;

    $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
    if($check !== false) {
        if (!file_exists($target_file)) {
            if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file)) {
                $img = basename($target_file);
            } else {
                echo $target_file;
                header("Location: register.html?error=upload_failed");
                exit();
            }
        } else {
            header("Location: register.html?error=file_exists");
            exit();
        }
    } else {
        header("Location: register.html?error=not_an_image");
        exit();
    }
}


if (emailExists($email, $db)) {
    header("Location: register.html?error=email_exists");
    exit();
}

$password = password_hash($password, PASSWORD_BCRYPT);

if ($insert_stmt = $db->getMysqli()->prepare("INSERT INTO users (username, email, pass, img) VALUES (?, ?, ?, ?)")) {    
   $insert_stmt->bind_param('ssss', $username, $email, $password, $img); 
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