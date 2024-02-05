<?php
require_once("db/database.php");
require_once("utils/function.php");
require_once("api/api.php");
require_once("login/functions.php");
safe_session_start();
define("POSTIMGDIR", "upload/post/");
define("PROFILEPICDIR", "upload/profile/");
$db = new DatabaseHelper("localhost", "root", "", "elaboratoWeb", 3306);
$api = new ApiHelper("https://api.tvmaze.com/");
?>