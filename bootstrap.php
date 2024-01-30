<?php
session_start();
require_once("db/database.php");
require_once("utils/function.php");
require_once("api/api.php");
$db = new DatabaseHelper("localhost", "root", "", "elaboratoWeb", 3306);
$api = new ApiHelper("https://api.tvmaze.com/");
?>