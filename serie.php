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
        break;
    }

} else {
    echo "Errore nella richiesta a TVmaze";
}

?>

<script>
    window.addEventListener('resize', function() {
    // Controlla la larghezza della finestra quando viene ridimensionata
    if(window.innerWidth <= 1300 && window.innerWidth > 1000){
        document.getElementById('bho').style = 'background-color: red';
        document.getElementById('searchInput').style = 'width: 100%';
        var postsSec = document.getElementById('posts-section');
        postsSec.style = 'margin-left: 0%; margin-right: 0%; gap: 0px;';
        var seasonsSec = document.getElementById('seasons-section');
        seasonsSec.style = 'margin-left: 0%; margin-right: 0%; width: 100%; justify-content: center;';
        var episodesSec = document.getElementById('episodi-section');
        episodesSec.style = 'margin-left: 0%; margin-right: 0%; width: 100%; justify-content: center;';
        //devo fare un foreach dove per ogni stagione, prendo l'id e la classe diventa class="card w-100 m-2"


    }else if (window.innerWidth <= 1000 && window.innerWidth >= 600) {
        // Esegui qualcosa quando la larghezza è inferiore o uguale a 700px
        // Ad esempio, cambia lo stile di un elemento HTML
        document.getElementById('bho').style = 'background-color: green';
        document.getElementById('searchInput').style = 'width: 100%';
        var postsSec = document.getElementById('posts-section');
        postsSec.style = 'margin-left: 0%; margin-right: 0%';
        var postGrid = document.getElementById('post-grid');
        postGrid.className = 'col-md-12';
        var sea_ep_Grid = document.getElementById('seasons-episodes-grid');
        sea_ep_Grid.className = '';
        var seasonsSec = document.getElementById('seasons-section');
        seasonsSec.style = 'margin-left: 0%; margin-right: 0%; width: 70%';
        var episodesSec = document.getElementById('episodi-section');
        episodesSec.style = 'margin-left: 0%; margin-right: 0%; width: 70%';

    } else if(window.innerWidth <= 800) {
        document.getElementById('bho').style = 'background-color: yellow';
        var postsSec = document.getElementById('posts-section');
        postsSec.style = 'margin-left: 0%; margin-right: 0%';
        var seasonsSec = document.getElementById('seasons-section');
        seasonsSec.style = 'margin-left: 0%; margin-right: 0%';
        var episodesSec = document.getElementById('episodi-section');
        episodesSec.style = 'margin-left: 0%; margin-right: 0%';
    } else {
        // Se la larghezza è superiore a 700px, ripristina lo stile dell'elemento
        document.getElementById('bho').style = 'background-color: aqua';
        document.getElementById('searchInput').style = 'width: 100%';
        document.getElementById('posts-section').style = 'margin-left: 5%; margin-right: 5%';
        var postGrid = document.getElementById('post-grid');
        postGrid.className = 'col-md-6';
        var sea_ep_Grid = document.getElementById('seasons-episodes-grid');
        sea_ep_Grid.className = 'col-md-6';
        var seasonsSec = document.getElementById('seasons-section');
        seasonsSec.style = '';
    }
});

    </script>

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

<body style="background-color: aqua;" id="bho">

<nav class="navbar navbar-expand-lg fixed-top bg-dark">
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
          <a class="nav-link text-white" href="#">Feed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="#">Profile</a>
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

<div class="container-fluid">
    <div class="row" id="rows">
        <div class="col-md-6" id="post-grid" style="background-color: purple;">
            <!-- Contenuto della colonna sinistra (Post) -->
            <section id="posts-section" class="posts" style = "width: 100%; justify-content: center;">
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
                                echo '<div class="card w-100 m-4" style="width: 15rem;" id="' . $season["number"] .'">';
                                echo '<img src="' . $season["image"]["medium"] . '" class="card-img-top" alt="Stagione ' . $season["number"] . '">';
                                echo '<div class="card-body" data-stagione-numero="' . $season["number"] . '">';
                                echo '<h5 class="card-title">Stagione: ' . $season["number"] .'</h5>';
                                echo '<p class="card-text">' . $season["summary"] .'</p>';
                                echo '<a class="btn btn-primary" onclick="caricaEpisodi(' . $season["number"] . ', ' . $season["id"] . ')">Guarda</a>';
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
                        <?php
                        foreach ($episodesData as $episodes) {
                            echo '<div class="card w-100 m-4" style="width: 15rem;"  >';
                            echo ' <img src="' . $episodes["image"]["medium"] . '" class="card-img-top" alt="Episodio ' . $episodes["number"] . '"> ';
                            echo '<div class="card-body" data-episodioNumero="' . $episodes["number"] . '">';
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

</body>
</html>