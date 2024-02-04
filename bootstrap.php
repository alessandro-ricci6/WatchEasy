<?php
require_once("db/database.php");
require_once("utils/function.php");
require_once("api/api.php");
define("POSTIMGDIR", "upload/post/");
$db = new DatabaseHelper("localhost", "root", "", "elaboratoWeb", 3306);
$api = new ApiHelper("https://api.tvmaze.com/");
?>