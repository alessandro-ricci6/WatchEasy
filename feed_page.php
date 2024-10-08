<?php 

require_once("feed_functions.php");
require_once 'bootstrap.php';
$templateParams['titolo'] = 'WatchEasy - Feed';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);
$showId = $db->getShowById($userId);
require 'template/base.php';

?>

<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/feed_style.css" type="text/css">
  <title>Document</title>
  <script src="script/searchbar.js"></script>
</head>
<body>
  <main>
    <div id = "search-container"class="input-group mb-3"></div>
      <!--<input type="text" id="search-input" placeholder="Cerca una serie TV"> -->
      <input type="text" id="search-input" class="form-control" placeholder="Cerca una serie TV" aria-describedby="button-addon2">
      <button id="button"class="btn btn-outline-secondary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
      </svg></button>
      <div id="results">

      </div>
    </div>
    <section>
      <div>
      <h1>Suggested Post</h1>
      <!--div che contiene i post-->
      <?php
      $templateParams['post'] = $db->getPostByShow($userId);
      require './template/lista-post.php';
      ?>
        
    </div>
    </section>
  </main>

  <script src="script/searchbar.js"></script>
</body>
</html>

