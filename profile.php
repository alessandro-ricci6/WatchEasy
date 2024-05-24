<?php

require_once 'bootstrap.php';
//include 'template/profile_page.php';

if(isset($_GET["username"])){
    $username = $_GET["username"];
}

$userId = $db->getUserIdByName($username);

if($_SESSION['user_id']) {
    $userId = $_SESSION['user_id'];
    $visit = $db->getUserIdByName($username);
    $templateParams['visit'] = $visit;
}

$templateParams['titolo'] = 'WatchEasy - Profilo';
//$templateParams['nome'] = 'profile_page.php';
$templateParams['username'] = $db->getUserName($userId);
$templateParams['post'] = $db->getPostByUserId($userId);
$templateParams['numpost'] = $db->getNumberOfPost($userId);
$templateParams['follower'] = $db->getNumberOfFollower($userId);
$templateParams['followed'] = $db->getNumberOfFollowed($userId);
$templateParams['show'] = $db->getShowByUserId($userId);
$templateParams['totepisode'] = $db->getViewedEpisodeNumber($userId);

require 'template/base.php'




?>
<head>
    <link rel="stylesheet" href="style/profile_style.css" type="text/css">
</head>
<body>
    <header class="bio">
        <img src="download.jpg" alt="foto profilo" >  
        <p><?php echo $templateParams['username']; ?></p>
        <button  class="follow" id="follow" onclick="follow()"> Follow </button>
    </header>
    <nav>
      <table id="first">
            <tr>
            <th>Follower</th>
            <th>Seguiti</th>
            <th>Post</th>
            </tr>
            <tr>
                <td><?php echo $templateParams['follower']; ?></td>
                <td><?php echo $templateParams['followed']; ?></td>
                <td><?php echo $templateParams['numpost']; ?></td>
            </tr>
        </table>
        <table id="second">
            <tr>
            <th>Serie viste</th>
            <th>Episodi Visti</th>
            </tr>
            <tr>
                <td> <?php echo count($templateParams['show']) ?></td>
                <td> <?php echo $templateParams['totepisode'] ?></td>
            </tr>
        </table>
    </nav>
    <main>
    <section>
        <h1>Serie Tv</h1>
        <div id="tab_img">
            <?php foreach($templateParams['show'] as $show):?>
                <img src="<?php echo $api->getTvShowById($show['showId'])['image']['medium'] ?>" alt="">
            <?php endforeach; ?>
        </div>
    </section>
      <h1>Post</h1>
        <div class="d-flex flex-column justify-content-center mx-4 px-3" id="postContainer">
        <?php 
        require 'template/lista-post.php' ?>
        </div>
    <footer>
        <form action="#" method="get">
            <input class = "add" type="button" value="+" id="post" onclick="redirect()">
            <label for="post">Aggiungi Post</label>
        </form>
    </footer>
</body>

    

    <script>
        function redirect() {
            windows.location.href="createPost.php"
        }
    </script>
    <script src="script/follow.js"></script>

