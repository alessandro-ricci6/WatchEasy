<?php

function safe_session_start() {
    $session_name = 'safe_session_id';
    $secure = true;
    $httponly = true;
    ini_set('session.use_only_cookies', 1);
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function login($email, $password, $mysqli) {
    $user_id = 0;
    $username = "";
    $db_password = "";
    
    if ($stmt = $mysqli->prepare("SELECT userId, username, pass FROM users WHERE email = ? LIMIT 1")) { 

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows == 1) { 

            $stmt->bind_result($user_id, $username, $db_password);
            $stmt->fetch();

            if(checkbrute($user_id, $mysqli) == true) {
                header('Location: ./login.php?blocked=too many attempts');
                exit();
            } else {
                if(password_verify($password, $db_password)) {       
                    echo "le password sono giuste";
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id; 
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $stmt2 = $mysqli->prepare("SELECT pass FROM users WHERE userId = ? LIMIT 1");
                    $stmt2->bind_param('i', $user_id);
                    $stmt2->execute();
                    $stmt2->store_result();
                    $stmt2->bind_result($password);
                    $stmt2->fetch();
                    $_SESSION['login_string'] = password_hash($password.$user_browser, PASSWORD_BCRYPT);
                    return true;    

                } else {
                    echo "le password non corrispondono: $password";
                    $now = time();
                    $mysqli->query("INSERT INTO log_attempts (user_id, time) VALUES ('$user_id', '$now')");
                    return false;
                }
            }

        } else {
            return false;
        }
    }
 }

function checkbrute($user_id, $mysqli) {
    $now = time();
    $valid_attempts = $now - (2 * 60 * 60); 
    if ($stmt = $mysqli->prepare("SELECT time FROM log_attempts WHERE user_id = ? AND time > '$valid_attempts'")) { 
       $stmt->bind_param('i', $user_id); 
       $stmt->execute();
       $stmt->store_result();
       if($stmt->num_rows > 20) {
          return true;
       } else {
          return false;
       }
    }
 }

 function login_check($mysqli) {
    $password = "";
    if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
      $user_id = $_SESSION['user_id'];
      $login_string = $_SESSION['login_string'];
      $username = $_SESSION['username'];     
      $user_browser = $_SERVER['HTTP_USER_AGENT'];
      if ($stmt = $mysqli->prepare("SELECT pass FROM users WHERE userId = ? LIMIT 1")) { 
         $stmt->bind_param('i', $user_id);
         $stmt->execute();
         $stmt->store_result();
  
         if($stmt->num_rows == 1) {
            $stmt->bind_result($password);
            $stmt->fetch();
            if(password_verify($password.$user_browser, $login_string)) {
               return true;
            } else {
                echo "stringa di login:     $login_string \n";
                echo "stringa di ora:     $password.$user_browser \n";
                echo "la password non corrisponde";
                return false;
            }
         } else {
            echo "l'utente non esiste";
            return false;
         }
      } else {
        echo "la query non è andata a buon fine";
        return false;
      }
    } else {
        echo $_SESSION['user_id'];
        echo "non esistono le variabili di sessione";
        return false;
    }
 }

?>