<?php

require_once 'bootstrap.php';

$templateParams['titolo'] = 'WatchEasy - Home';
$templateParams['nome'] = 'lista-post.php';
$templateParams['post'] = $db->getPost(3);

require 'template/base.php';

?>