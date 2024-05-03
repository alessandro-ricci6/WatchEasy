<?php

require_once 'bootstrap.php';

if(isset($_POST["query"])) {
    $output = "<ul style='list-style: none'>";
    $result = $db->searchUser($_POST["query"]);

    if($result > 0) {
        foreach($result as $user){
            $output .= "<li><a href='./profile.php?username=" . $user['username'] . "'>" . $user['username'] . "</a></li>";
        }
    }
    $output .= "</ul>";
    echo $output;
}


?>