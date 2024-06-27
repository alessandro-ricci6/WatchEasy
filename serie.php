<?php

require_once 'bootstrap.php'; 

$selectedSeriesId = $_GET["id"];

if(!isset($_SESSION['user_id'])) {
    $_SESSION['current_page'] = "../serie.php?id=" . $selectedSeriesId;
    header("Location: ./login/login_check.php");
    exit();
}

$tvmazeAPIKey = "atkuTO5oSPWX1qRXHeYaKzyle6DS86o7";
$tvmazeURL = "https://api.tvmaze.com/shows/" . $selectedSeriesId;

$response = file_get_contents($tvmazeURL);
$data = json_decode($response, true);

if ($data) {
    $seriesTitle = $data["name"];
    $seriesSummary = $data["summary"];

    $seasonsURL = "https://api.tvmaze.com/shows/" . $data["id"] . "/seasons";
    $seasonsResponse = file_get_contents($seasonsURL);
    $seasonsData = json_decode($seasonsResponse, true);
    foreach($seasonsData as $season){
        $episodesURL = "https://api.tvmaze.com/seasons/"  . $season["id"] .  "/episodes";
        $episodesResponse = file_get_contents($episodesURL);
        $episodesData = json_decode($episodesResponse, true);
        $seasonId = $season["id"];
        $seasonNumber = $season["number"];
        break;
    }

} else {
    echo "Errore nella richiesta a TVmaze";
}

?>

<!-- INIZIO HTML + JS -->

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seriesTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="./style/serie.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./script/research.js"></script>
</head>
<?php
    echo '<script>';
    echo 'saveSeasonNumber(' . $seasonNumber . ');';
    echo 'saveSeasonId(' . $seasonId . ');';
    echo 'saveSelectedSeries(' . $selectedSeriesId . ');';
    echo '</script>';
?>

<script>
    let screenTotal = screen.width;
    let screenTotalHeight =screen.height;
    let currentLayout = "";

    function redimensionPage() {
    if (window.innerWidth <= (screenTotal / 2) && window.innerWidth > 500) {
        if(currentLayout != "half-screen"){
        document.getElementById('bho').style = 'background-color: green';
        var postGrid = document.getElementById('post-grid');
        postGrid.className = 'col-md-12';
        var sea_ep_Grid = document.getElementById('seasons-episodes-grid');
        sea_ep_Grid.className = 'col-md-12';
        var sea_Grid = document.getElementById('seasons-grid');
        sea_Grid.className = 'col-md-6';
        var ep_Grid = document.getElementById('episodes-grid');
        ep_Grid.className = 'col-md-6';
        sea_Grid.style.flex = '1 1 50%';
        ep_Grid.style.flex = '1 1 50%';
        sea_Grid.style.maxWidth = '50%';
        ep_Grid.style.maxWidth = '50%';
        var seasonsSec = document.getElementById('seasons-section');
        var episodesSec = document.getElementById('episodi-section');
        var postSection = document.getElementById("posts-section");

        var windowHeight = screenTotalHeight / 1.4;
        if(seasonsSec.offsetHeight <= (windowHeight)){
            episodesSec.style.maxHeight = windowHeight + "px";
            postSection.style.maxHeight = windowHeight + "px";
        }else{
            episodesSec.style.maxHeight = seasonsSec.offsetHeight + "px";
            postSection.style.maxHeight = seasonsSec.offsetHeight + "px";
        }

        console.log("seasonNumber", getSeasonNumber());
        console.log("seasonId", getSeasonId());
        console.log("season series id", getSelectedSeries());
        if((getSeasonNumber() && getSeasonId()) != 0){
            caricaEpisodi(getSeasonNumber(),getSeasonId(),getSelectedSeries());
        }

        currentLayout = "half-screen";
    }
    } else if(window.innerWidth <= 500){
        if(currentLayout != "small-screen"){
        document.getElementById('bho').style = 'background-color: red';
        var postGrid = document.getElementById('post-grid');
        postGrid.className = 'col-md-6';
        var sea_ep_Grid = document.getElementById('seasons-episodes-grid');
        sea_ep_Grid.className = 'col-md-6';
        var sea_Grid = document.getElementById('seasons-grid');
        sea_Grid.className = '';
        var ep_Grid = document.getElementById('episodes-grid');
        ep_Grid.className = '';
        sea_Grid.style = '';
        ep_Grid.style = '';
        var seasonsSec = document.getElementById('seasons-section');
        var episodesSec = document.getElementById('episodi-section');
        var postSection = document.getElementById("posts-section");

        var windowHeight = screenTotalHeight / 1.4;
        if(seasonsSec.offsetHeight <= (windowHeight)){
            episodesSec.style.maxHeight = windowHeight + "px";
            postSection.style.maxHeight = windowHeight + "px";
            console.log("entrato 1", postSection.offsetHeight);
        }else{
            episodesSec.style.maxHeight = seasonsSec.offsetHeight + "px";
            postSection.style.maxHeight = windowHeight + "px";
            console.log("entrato 2", postSection.offsetHeight);
        }

        console.log("seasonNumber", getSeasonNumber());
        console.log("seasonId", getSeasonId());
        console.log("season series id", getSelectedSeries());
        if((getSeasonNumber() && getSeasonId()) != 0){
            caricaEpisodi(getSeasonNumber(),getSeasonId(),getSelectedSeries());
        }

        currentLayout = "small-screen";
        }
    } else{
        //default
        if(currentLayout != "default-screen"){
        document.getElementById('bho').style = 'background-color: aqua';
        var postGrid = document.getElementById('post-grid');
        postGrid.className = 'col-md-6';
        var sea_ep_Grid = document.getElementById('seasons-episodes-grid');
        sea_ep_Grid.className = 'col-md-6';
        var sea_Grid = document.getElementById('seasons-grid');
        sea_Grid.className = 'col-md-6';
        var ep_Grid = document.getElementById('episodes-grid');
        ep_Grid.className = 'col-md-6';
        sea_Grid.style = 'background-color: pink';
        ep_Grid.style = 'background-color: lime';
        var seasonsSec = document.getElementById('seasons-section');
        var episodesSec = document.getElementById('episodi-section');
        var postSection = document.getElementById("posts-section");

        var windowHeight = screenTotalHeight / 1.4;
        if(seasonsSec.offsetHeight <= (windowHeight)){
            episodesSec.style.maxHeight = windowHeight + "px";
            postSection.style.maxHeight = windowHeight + "px";
        }else{
            episodesSec.style.maxHeight = seasonsSec.offsetHeight + "px";
            postSection.style.maxHeight = seasonsSec.offsetHeight + "px";
        }

        currentLayout = "default-screen";
        }
    }
    }
    </script>

<body style="background-color: aqua;" id="bho">

<nav id="navbarUp" class="navbar navbar-expand-lg fixed-top bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white"><?php echo $seriesTitle; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <?php
            $_SESSION['current_page'] = '../index.php';
            ?>
          <a class="nav-link active text-white" aria-current="page" href="login/login_check.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white"  href="login/login_check.php?page=feed">Feed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white"  href="login/login_check.php?page=profile">Profile</a>
        </li>
      </ul>

    </div>
  </div>
</nav>

<header>
    <h1 id="serie-title" style ="font-weight: bold;"><?php echo $seriesTitle; ?></h1>
</header>
    <input class="form-control me-2" type="search" placeholder="Search the episode..." aria-label="Search" id="searchInput" 
        oninput="effettuaRicerca('<?php echo $seasonsURL; ?>');">
<p style ="font-weight: bold;"><?php echo $seriesSummary; ?></p>

<script>
    var navbar = document.getElementById("navbarUp");
    var searchbar = document.getElementById("searchInput");
    searchbar.style.position = 'sticky';
    searchbar.style.top = navbar.offsetHeight + "px";
    searchbar.style.zIndex = '1';
</script>

<div class="container-fluid">
    <div class="row" id="rows">
        <div class="col-md-6" id="post-grid" style="background-color: purple;">
            <!-- Contenuto della colonna sinistra (Post) -->
            <section id="posts-section" class="posts" style = "width: 100%;">
                <div class="w-100 p-4" style="width: 15rem;">
                    <?php
                        $templateParams['post'] = $db->getPostOfSeriesById($data["id"]);
                        require './template/lista-post.php';
                    ?>
                </div>
            </section>
        </div>
        <div class="col-md-6" id="seasons-episodes-grid">
            <!-- Contenuto della colonna destra (Stagioni ed Episodi) -->
            <div class="row">
                <div class="col-md-6" id="seasons-grid" style="background-color: pink;">
                    <!-- Contenuto delle stagioni -->
                    <section id="seasons-section" class="stagioni">
                        <!-- Contenuto delle stagioni -->
                        <?php
                            foreach ($seasonsData as $season) {
                                echo '<div class="card w-100 m-4 card-stagione" style="width: 15rem;" id="' . $season["number"] .'">';
                                if($season["image"] != null){
                                    echo '<img src="' . $season["image"]["medium"] . '" class="card-img-top" alt="Stagione ' . $season["number"] . '">';
                                }
                                echo '<div class="card-body" data-stagione-numero="' . $season["number"] . '">';
                                echo '<h5 class="card-title">Stagione: ' . $season["number"] .'</h5>';
                                echo '<p class="card-text">' . $season["summary"] .'</p>';
                                echo '<a class="btn btn-primary" onclick="caricaEpisodi(' . $season["number"] . ', ' . $season["id"] . ', ' . $selectedSeriesId . ')">Guarda</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        ?>
                    </section>
                </div>
                <div class="col-md-6" id="episodes-grid" style="background-color: lime;">
                    <!-- Contenuto degli episodi -->
                    <section id="episodi-section" class="episodi">
                        <!-- Contenuto degli episodi -->
                        <script>
                            var windowHeight = screenTotalHeight / 1.4;
                            var seasonsSection = document.getElementById("seasons-section");
                            var episodiSection = document.getElementById("episodi-section");
                            var postSection = document.getElementById("posts-section");
                            if(seasonsSection.clientHeight <= (windowHeight)){
                                episodiSection.innerHTML = "";
                                episodiSection.style.maxHeight = windowHeight + "px";
                                postSection.style.maxHeight = windowHeight + "px";
                            }else{
                                episodiSection.innerHTML = "";
                                episodiSection.style.maxHeight = seasonsSection.clientHeight + "px";
                                postSection.style.maxHeight = seasonsSection.clientHeight + "px";
                            }
                        </script>
                        <?php
                        foreach ($episodesData as $episodes) {
                            echo '<div class="card w-100 m-4" style="width: 15rem;"  >';
                            if($episodes["image"] != null){
                                echo ' <img src="' . $episodes["image"]["medium"] . '" class="card-img-top" alt="Episodio ' . $episodes["number"] . '"> ';
                            }
                            echo '<div class="card-body" data-episodio-numero="' . $episodes["number"] . '">';
                            echo '<h5 class="card-title">' . $episodes["name"] . '</h5>
                            <p class="card-text">' . $episodes["summary"] . '</p>' . '<a class="btn btn-primary" >Guarda</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="risultati-grid">
                    <!-- Contenuto della riga inferiore (Risultati) -->
                    <section id="risultati-section" class="risultati d-flex flex-wrap">
                        <!-- Risultati della ricerca saranno caricati qui -->
                    </section>
                </div>
            </div>
        </div>
    </div>  
</div>

<script>
    document.addEventListener('DOMContentLoaded', redimensionPage);
    window.addEventListener('resize', redimensionPage);
</script>

</body>
</html>