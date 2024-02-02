<?php

require_once 'bootstrap.php';

if(isset($_POST["query"])) {
    $output = "";
    $result = $db->searchUser($_POST["query"]);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $output .= '<a href="profile.php?username='.$row['username'].'">' . $row['username'] . '</a>';   
        }
    } else {
        $output .= '<p>Utente non trovato</p>';
    }
    echo $output;
}


?>