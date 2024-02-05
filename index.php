<?php
require_once 'bootstrap.php';
ini_set('display_errors',1 );

$templateParams['titolo'] = 'WatchEasy - Home';
$templateParams['nome'] = 'home.php';
$templateParams['post'] = $db->getPostOfFollowing($_SESSION['user_id']);

require 'template/base.php';

?>