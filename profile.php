<?php

require_once 'bootstrap.php';
//include 'template/profile_page.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && isset($_POST['userId']) && isset($_POST['followId'])) {
        $userId = $_SESSION['user_id'];
        $followId = $_POST['followId'];
        $visitedUser = $db->getUserIdByName($followId);

        if ($_POST['action'] == 'remove') {
            $db->removeFollower($userId, $visitedUser);
        } elseif ($_POST['action'] == 'add') {
            $db->addFollower($userId, $visitedUser);
            $db->addFollowNotification($userId, $visitedUser);
        }
        exit;
    }
}

if(isset($_GET["username"])){
    $username = $_GET["username"];
}
$visitedUser = $db->getUserIdByName($username);
$userId = $_SESSION['user_id'];

$templateParams['titolo'] = 'WatchEasy - Profilo';
$templateParams['username'] = $db->getUserName($visitedUser);
$templateParams['post'] = $db->getPostByUserId($visitedUser);
$templateParams['numpost'] = $db->getNumberOfPost($visitedUser);
$templateParams['follower'] = $db->getNumberOfFollower($visitedUser);
$templateParams['followed'] = $db->getNumberOfFollowed($visitedUser);
$templateParams['show'] = $db->getShowByUserId($visitedUser);
$templateParams['totepisode'] = $db->getViewedEpisodeNumber($visitedUser);
$templateParams['img'] = $db->getImage($visitedUser);

require 'template/base.php'




?>
<head>
    <link rel="stylesheet" href="style/profile_style.css" type="text/css">
</head>
<body>
    <header class="bio">
        <img src="<?php echo $templateParams['img'] ?>" alt="profile" >  
        <p><?php echo $templateParams['username']; ?></p>
        <button  class="follow" id="follow" > Follow </button>
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
</body>


<script>
    document.getElementById('follow').addEventListener("click", function() {
        var button = this;
        var action = button.classList.contains('clicked') ? 'remove' : 'add';

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if(action === 'remove') {
                    button.classList.remove('clicked');
                    button.innerText = 'Follow';
                } else {
                    button.classList.add('clicked');
                    button.innerText = 'Followed';
                }
            }
        };
        xhr.send("action=" + action + "&userId=" + <?php echo json_encode($userId); ?> + "&followId=" + <?php echo json_encode($username); ?>);
    });
</script>

<?php
   

    if(isset($_GET['username']) && !empty($_GET['username'])) {
        $followId = $_GET['username'];
        $result = $db->getFollower($userId,$visitedUser);

        if($result!= 0){
            ?>
            <script>
                document.getElementById('follow').classList.add('clicked');
                document.getElementById('follow').innerText = 'Followed';
                
            </script>
            <?php
        } else {
            ?>
            <script>
                document.getElementById('follow').classList.remove('clicked');
                document.getElementById('follow').innerText = 'Follow';

            </script>
            <?php
            
        }
        

    }
    

    ?>
