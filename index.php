<?php
require_once 'bootstrap.php';

$templateParams['titolo'] = 'WatchEasy - Home';
$templateParams['nome'] = 'lista-post.php';
$templateParams['post'] = $db->getPostOfFollowing($_SESSION['user_id']);

require 'template/base.php';

?>