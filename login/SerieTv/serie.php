<?php

require_once '../../bootstrap.php'; 

$selectedSeriesId = $_GET["id"];

if(!isset($_SESSION['user_id'])) {
    $_SESSION['current_page'] = "SerieTv/serie.php?id=" . $selectedSeriesId;
    header("Location: ./../login_check.php");
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

} else {
    echo "Errore nella richiesta a TVmaze";
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $seriesTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="../../style/serie.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../script/research.js"></script>
</head>

<body style="background-color: aqua;">

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
          <a class="nav-link active text-white" aria-current="page" href="../login_check.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="#">Feed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="#">Profile</a>
        </li>
      </ul>
        <input class="form-control me-2" type="search" placeholder="Search the episode..." aria-label="Search" id="searchInput" 
        oninput="effettuaRicerca('<?php echo $seasonsURL; ?>');">
    </div>
  </div>
</nav>

<header>
    <h1 id="serie-title" style ="font-weight: bold;"><?php echo $seriesTitle; ?></h1>
</header>
<p style ="font-weight: bold;"><?php echo $seriesSummary; ?></p>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <!-- Contenuto della colonna sinistra (Post) -->
            <section id="posts-section" class="posts">
                <div class="w-100 p-4" style="width: 15rem;">
                    <?php
                        $templateParams['post'] = $db->getPostOfSeriesById($data["id"]);
                        require '../../template/lista-post.php';
                    ?>
                </div>
            </section>
        </div>
        <div class="col-md-6">
            <!-- Contenuto della colonna destra (Stagioni ed Episodi) -->
            <div class="row">
                <div class="col-md-6">
                    <!-- Contenuto delle stagioni -->
                    <section id="seasons-section" class="stagioni">
                        <!-- Contenuto delle stagioni -->
                        <?php
                            foreach ($seasonsData as $season) {
                                echo '<div class="card w-100 m-4" style="width: 15rem;">';
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
                <div class="col-md-6">
                    <!-- Contenuto degli episodi -->
                    <section id="episodi-section" class="episodi">
                        <!-- Contenuto degli episodi -->
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
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