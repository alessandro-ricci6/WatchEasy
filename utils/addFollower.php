<?php

require 'bootstrap.php';
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

/*come parametro dovrei passare il id di chi controlla, have to check*/
$userId = NULL;
$visited = NULL;


$query = "INSERT INTO follow (fromUserid, toUserid) VALUES (?, ?)";
$stmt->bind_param('ii', $userId, $visited);
$stmt->execute();

if ($db->query($query) === TRUE) {
    $last_id = $db->insert_id;
    echo "Persona aggiunta correttamente con id: " . $last_id;
} else {
    echo "Errore: " . $query . "<br>" . $db->error;
}

$db->close();