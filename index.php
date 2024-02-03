<?php

require_once 'bootstrap.php';

$templateParams['titolo'] = 'WatchEasy - Home';
$templateParams['nome'] = 'lista-post.php';
$templateParams['post'] = $db->getPostOfFollowing(1);

require 'template/base.php';

?>