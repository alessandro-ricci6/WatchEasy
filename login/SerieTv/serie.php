<?php

require_once '../../bootstrap.php'; 

$selectedSeriesId = $_GET["id"];

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
    <link rel="stylesheet" type="text/css" href="serie.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
        <!--<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>-->
        </li>
      </ul>
      <!--<form action="serie.php?name=Peaky%20Blinders" method="post" class="d-flex" role="search">-->
        <input class="form-control me-2" type="search" placeholder="Search the episode..." aria-label="Search" id="searchInput" 
        oninput="effettuaRicerca('<?php echo $seasonsURL; ?>');">
        <!--<button class="btn btn-outline-success" onclick="effettuaRicerca('<?php //echo $seasonsURL; ?>');">Search</button>
      </form>-->
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












<script>

    function caricaEpisodi(stagioneNumero, stagioneId) {

        console.log("Cliccato su stagione " + stagioneNumero);
    // URL per ottenere gli episodi della stagione selezionata
    var episodesURL = "https://api.tvmaze.com/seasons/" + stagioneId + "/episodes";
    // Effettua la richiesta fetch
    fetch(episodesURL)
        .then(response => {
            // Verifica se la risposta è OK
            if (!response.ok) {
                throw new Error('Errore nella richiesta degli episodi');
            }
            // Parsa la risposta JSON
            return response.json();
        })
        .then(episodiData => {

            var seasonsSection = document.getElementById("seasons-section");
            var seasonsHeight = seasonsSection.clientHeight;
            var episodiSection = document.getElementById("episodi-section");
            episodiSection.innerHTML = "";
            episodiSection.style.maxHeight = seasonsHeight + "px";

            // Aggiungi gli episodi alla sezione degli episodi
            episodiData.forEach(episodio => {
                var episodioDiv = document.createElement("div");
                episodioDiv.className = "card w-100 m-4";
                episodioDiv.style = "width: 15rem;";
                episodioDiv.innerHTML = '<img src="' + episodio["image"]["medium"] + '" class="card-img-top" alt="Episodio ' + episodio["number"] + '">';

                var episodioDiv2 = document.createElement("div");
                episodioDiv2.className = "card-body";
                episodioDiv2.dataset.episodioNumero = episodio["number"];
                episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                '<p class="card-text">' + episodio["summary"] + '</p>' + '<a class="btn btn-primary" >Guarda</a>';

                episodioDiv.appendChild(episodioDiv2);
                episodiSection.appendChild(episodioDiv);
            });
        })
        .catch(error => {
            // La richiesta ha restituito un errore
            console.error(error.message);
        });
    }









    function effettuaRicerca(seasonsUrl) {
    // Ottieni il valore inserito nella barra di ricerca
    var searchTerm = document.getElementById('searchInput').value;
    console.log('Ricerca per: ' + searchTerm);

    // Effettua la ricerca solo se è presente un termine di ricerca
    if (searchTerm.trim() !== "") {

        // Effettua la richiesta fetch
                var postsSection = document.getElementById("posts-section");
                postsSection.innerHTML = "";
                var seasonsSection = document.getElementById("seasons-section");
                seasonsSection.innerHTML = "";
                var episodiSection = document.getElementById("episodi-section");
                episodiSection.innerHTML = "";
                var risultatiSection = document.getElementById("risultati-section");
                risultatiSection.innerHTML = "";    

                    // URL per ottenere le stagioni dello show
                    var seasonsURL = seasonsUrl;

                    // Effettua la richiesta per ottenere le stagioni
                    fetch(seasonsURL)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Errore nel recupero delle stagioni');
                            }
                            return response.json();
                        })
                        .then(seasonsData => {
                            // Loop attraverso le stagioni
                            seasonsData.forEach(season => {
                                // Verifica se il nome della stagione contiene il termine di ricerca
                                if (season.name.toLowerCase().includes(searchTerm.toLowerCase())) {
                                    // Aggiungi la stagione ai risultati
                                    var stagioneDiv = document.createElement("div");
                                    stagioneDiv.className = "stagione";
                                    stagioneDiv.innerHTML = '<p>Stagione: ' + season.number + '</p>';
                                    risultatiSection.appendChild(stagioneDiv);
                                }

                                // URL per ottenere gli episodi della stagione
                                var episodesURL = "https://api.tvmaze.com/seasons/" + season.id + "/episodes";

                                // Effettua la richiesta per ottenere gli episodi della stagione
                                fetch(episodesURL)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Errore nel recupero degli episodi');
                                        }
                                        return response.json();
                                    })
                                    .then(episodesData => {
                                        // Loop attraverso gli episodi
                                        episodesData.forEach(episode => {
                                            // Verifica se il nome dell'episodio contiene il termine di ricerca
                                            if (episode.name.toLowerCase().includes(searchTerm.toLowerCase())) {
                                                // Aggiungi l'episodio ai risultati
                                                
                                                var episodioDiv = document.createElement("div");
                                                episodioDiv.className = "card";
                                                episodioDiv.style = "width: 15rem;";
                                                episodioDiv.innerHTML = '<img src="' + episode["image"]["medium"] + '" class="card-img-top" alt="Episodio ' + episode["number"] + '">';

                                                var episodioDiv2 = document.createElement("div");
                                                episodioDiv2.className = "card-body";
                                                episodioDiv2.dataset.episodioNumero = episode["number"];
                                                episodioDiv2.innerHTML = '<h5 class="card-title">' + episode["name"] + '</h5>' + 
                                                '<p class="card-text">' + episode["summary"] + '</p>' + '<a class="btn btn-primary" >Guarda</a>';

                                                episodioDiv.appendChild(episodioDiv2);
                                                risultatiSection.appendChild(episodioDiv);
                                            }
                                        });
                                    })
                                    .catch(error => {
                                        console.error(error.message);
                                    });
                            });
                        })
                        .catch(error => {
                            console.error(error.message);
                        });
          
    } else if((searchTerm.trim() === "") || searchTerm.length === 0){
      var seasonsURL = seasonsUrl;
          var postsSection = document.getElementById("posts-section");
          postsSection.innerHTML = "";
          var episodiSection = document.getElementById("episodi-section");
          episodiSection.innerHTML = "";
          var risultatiSection = document.getElementById("risultati-section");
          risultatiSection.innerHTML = "";
          
            /*var postDiv = document.createElement("div");
            postDiv.className = "w-100 p-4";
            postDiv.style = "width: 15rem;";
            postDiv.innerHTML = templatePost;
            postsSection.appendChild(postDiv);*/

// Effettua la richiesta per ottenere le stagioni
fetch(seasonsURL)
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore nel recupero delle stagioni');
        }
        return response.json();
    })
    .then(seasonsData => {

      var seasonsSection = document.getElementById("seasons-section");
              seasonsSection.innerHTML = "";

        // Loop attraverso le stagioni
        seasonsData.forEach(season => {

                var seasonDiv = document.createElement("div");
                seasonDiv.className = "card w-100 m-4";
                seasonDiv.style = "width: 15rem;";
                seasonDiv.innerHTML = '<img src="' + season["image"]["medium"] + '" class="card-img-top" alt="Stagione ' + season["number"] + '">';

                var seasonDiv2 = document.createElement("div");
                seasonDiv2.className = "card-body";
                seasonDiv2.dataset.stagioneNumero = season["number"];
                seasonDiv2.innerHTML = '<h5 class="card-title">Stagione: ' + season["number"] + '</h5>' + 
                '<p class="card-text">' + season["summary"] + '</p>' + '<a class="btn btn-primary" onclick="caricaEpisodi(' + season["number"] + ', ' + season["id"] + ')">Guarda</a>';

                seasonDiv.appendChild(seasonDiv2);
                seasonsSection.appendChild(seasonDiv);

          });
      })
    }
}




</script>
</body>
</html>
