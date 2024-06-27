var seasonNumber = 0;
var seasonId = 0;
var selectedSeries = 0;
function caricaEpisodi(stagioneNumero, stagioneId, selectedSeriesId) {

    saveSeasonNumber(stagioneNumero);
    saveSeasonId(stagioneId);
    saveSelectedSeries(selectedSeriesId);
    console.log("Cliccato su stagione " + stagioneNumero);
    var tvmazeURL = "https://api.tvmaze.com/shows/" + selectedSeriesId;

    fetch(tvmazeURL)
    .then(response => {
        // Verifica se la risposta è OK
        if (!response.ok) {
            throw new Error('Errore nella richiesta degli episodi');
        }
        // Parsa la risposta JSON
        return response.json();
    }).then(data => {
        var seasonsURL = "https://api.tvmaze.com/shows/" + data["id"] + "/seasons";
        fetch(seasonsURL)
        .then(response => {
                // Verifica se la risposta è OK
                if (!response.ok) {
                    throw new Error('Errore nella richiesta degli episodi');
                }
                // Parsa la risposta JSON
                return response.json();
            })
            .then(seasonsData => {
                seasonsData.forEach(season => {
                console.log("stagione loop " + season.number);
                var seasonsNumber = document.getElementById(season.number);
                if(season.image != null){
                    while(seasonsNumber.childElementCount > 2){
                        seasonsNumber.removeChild(seasonsNumber.lastChild);
                        if(seasonsNumber.childElementCount == 2){
                            var heightDefault = seasonsNumber.style.height;
                        }
                    }
                }else{ 
                    while(seasonsNumber.childElementCount > 1){
                        seasonsNumber.removeChild(seasonsNumber.lastChild);
                        if(seasonsNumber.childElementCount == 1){
                            var heightDefault = seasonsNumber.style.height;
                        }
                    }
                }
                    seasonsNumber.style.maxHeight = heightDefault;
                });


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

        var windowHeight = screen.height / 1.4;
        var seasonsSection = document.getElementById("seasons-section");
        var episodiSection = document.getElementById("episodi-section");
        if(seasonsSection.clientHeight <= (windowHeight)){
            episodiSection.innerHTML = "";
            episodiSection.style.maxHeight = windowHeight + "px";
        }else{
            episodiSection.innerHTML = "";
            episodiSection.style.maxHeight = seasonsSection.clientHeight + "px";
        }

        console.log("andata " + stagioneNumero);

        if(window.innerWidth <= 500){
            var seasonsNumber = document.getElementById(stagioneNumero);
            console.log("height " + seasonsNumber.offsetHeight);
            console.log("window " + (screen.height / 2));
            if(seasonsNumber.offsetHeight > (screen.height / 2)){
                seasonsNumber.style.maxHeight = (screen.height) + "px";
            }else{
                seasonsNumber.style.maxHeight = (screen.height / 1.5) + "px";
            }
            episodiData.forEach(episodio => {
                var episodioDiv = document.createElement("div");
                episodioDiv.id = "ep." + episodio["number"];
                episodioDiv.className = "card w-100 p-2 d-flex justify-content-center align-items-center";
                episodioDiv.style = "width: 15rem;";
                if(episodio["image"] != null){
                    episodioDiv.innerHTML = '<img src="' + episodio["image"]["medium"] + '" class="card-img-top" alt="Episodio ' + episodio["number"] + '">';
                }
    
                var episodioDiv2 = document.createElement("div");
                episodioDiv2.className = "card-body";
                episodioDiv2.dataset.episodioNumero = episodio["number"];
                if(episodio["summary"] != null){
                    episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                '<p class="card-text">' + episodio["summary"] + '</p>' + '<a class="btn btn-primary" >Guarda</a>';
                }else{
                    episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                '<p class="card-text"></p>' + '<a class="btn btn-primary" >Guarda</a>';
                }
    
                episodioDiv.appendChild(episodioDiv2);
                seasonsNumber.appendChild(episodioDiv);
            });
        }else {

            // Aggiungi gli episodi alla sezione degli episodi
            episodiData.forEach(episodio => {
                var episodioDiv = document.createElement("div");
                episodioDiv.className = "card w-100 m-4";
                episodioDiv.style = "width: 15rem;";
                if(episodio["image"] != null){
                    episodioDiv.innerHTML = '<img src="' + episodio["image"]["medium"] + '" class="card-img-top" alt="Episodio ' + episodio["number"] + '">';
                }

                var episodioDiv2 = document.createElement("div");
                episodioDiv2.className = "card-body";
                episodioDiv2.dataset.episodioNumero = episodio["number"];
                if(episodio["summary"] != null){
                    episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                    '<p class="card-text">' + episodio["summary"] + '</p>' + '<a class="btn btn-primary" >Guarda</a>';
                }else{
                    episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                    '<p class="card-text"></p>' + '<a class="btn btn-primary" >Guarda</a>';
                }

            episodioDiv.appendChild(episodioDiv2);
            episodiSection.appendChild(episodioDiv);
            });
        }
    })
            .catch(error => {
                // La richiesta ha restituito un errore
                console.error(error.message);
            });




        })//seasonData
    }) 
}

function saveSeasonNumber(stagioneNumero){
    seasonNumber = stagioneNumero;
}

function getSeasonNumber(){
    return seasonNumber;
}

function saveSeasonId(stagioneId){
    seasonId = stagioneId;
}

function getSeasonId(){
    return seasonId;
}

function saveSelectedSeries(selectedSeriesId){
    selectedSeries = selectedSeriesId;
}

function getSelectedSeries(){
    return selectedSeries;
}

function effettuaRicerca(seasonsUrl) {
// Ottieni il valore inserito nella barra di ricerca
var searchTerm = document.getElementById('searchInput').value;
console.log('Ricerca per: ' + searchTerm);

// Effettua la ricerca solo se è presente un termine di ricerca
if (searchTerm.trim() !== "") {

    // Effettua la richiesta fetch
            let screenTotal = screen.height;
            var seasonsSection = document.getElementById("seasons-section");
            seasonsSection.innerHTML = "";
            var episodiSection = document.getElementById("episodi-section");
            episodiSection.innerHTML = "";
            var risultatiSection = document.getElementById("risultati-section");
            risultatiSection.innerHTML = "";
            var postsSection = document.getElementById("posts-section");
            if(postsSection.offsetHeight >= (screenTotal / 1.5)){
                risultatiSection.style.maxHeight = postsSection.offsetHeight + "px";
            }else {
                risultatiSection.style.maxHeight = screenTotal + "px";
            }

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
                                            if(episode["image"] != null){
                                                episodioDiv.innerHTML = '<img src="' + episode["image"]["medium"] + '" class="card-img-top" alt="Episodio ' + episode["number"] + '">';
                                            }

                                            var episodioDiv2 = document.createElement("div");
                                            episodioDiv2.className = "card-body";
                                            episodioDiv2.dataset.episodioNumero = episode["number"];
                                            if(episode["summary"] != null){
                                                episodioDiv2.innerHTML = '<h5 class="card-title">' + episode["name"] + '</h5>' + 
                                            '<p class="card-text">' + episode["summary"] + '</p>' + '<a class="btn btn-primary" >Guarda</a>';
                                            }else {
                                                episodioDiv2.innerHTML = '<h5 class="card-title">' + episode["name"] + '</h5>' + 
                                            '<p class="card-text"></p>' + '<a class="btn btn-primary" >Guarda</a>';
                                            }

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
      
      var episodiSection = document.getElementById("episodi-section");
      episodiSection.innerHTML = "";
      var risultatiSection = document.getElementById("risultati-section");
      risultatiSection.innerHTML = "";
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
    var risultatiSection = document.getElementById("risultati-section");
    risultatiSection.innerHTML = "";
    var episodiSection = document.getElementById("episodi-section");
    episodiSection.innerHTML = "";
    console.log("cancello stagioni", 1);
    // Loop attraverso le stagioni
    seasonsData.forEach(season => {

        console.log("stagione numero", season["number"]);
            var seasonDiv = document.createElement("div");
            seasonDiv.id = season["number"];
            seasonDiv.className = "card w-100 m-4 card-stagione";
            seasonDiv.style = "width: 15rem;";
            if(season["image"] != null){
                seasonDiv.innerHTML = '<img src="' + season["image"]["medium"] + '" class="card-img-top" alt="Stagione ' + season["number"] + '">';
            }

            var seasonDiv2 = document.createElement("div");
            seasonDiv2.className = "card-body";
            seasonDiv2.dataset.stagioneNumero = season["number"];
            if(season["summary"] != null){
                seasonDiv2.innerHTML = '<h5 class="card-title">Stagione: ' + season["number"] + '</h5>' + 
            '<p class="card-text">' + season["summary"] + '</p>' + '<a class="btn btn-primary" onclick="caricaEpisodi(' + season["number"] + ', ' + season["id"] + ', ' + getSelectedSeries() + ')">Guarda</a>';
            }else {
                seasonDiv2.innerHTML = '<h5 class="card-title">Stagione: ' + season["number"] + '</h5>' + 
            '<p class="card-text"></p>' + '<a class="btn btn-primary" onclick="caricaEpisodi(' + season["number"] + ', ' + season["id"] + ', ' + getSelectedSeries() + ')">Guarda</a>';
            }

            seasonDiv.appendChild(seasonDiv2);
            seasonsSection.appendChild(seasonDiv);

      });

      var episodesURL = "https://api.tvmaze.com/seasons/"  + getSeasonId() +  "/episodes";

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

        let screenTotal = screen.height;
        var seasonsSection = document.getElementById("seasons-section");
        if(seasonsSection.clientHeight <= (screenTotal / 1.4)){
            episodiSection.innerHTML = "";
            episodiSection.style.maxHeight = (screenTotal / 1.4) + "px";
        }else{
            episodiSection.innerHTML = "";
            episodiSection.style.maxHeight = seasonsSection.clientHeight + "px";
        }

        var seasonsNumber = document.getElementById(getSeasonNumber());
        console.log("number of children", seasonsNumber.childElementCount);

        if(window.innerWidth <= 500){
            console.log("height 2 " + seasonsNumber.offsetHeight);
            console.log("window 2 " + (screen.height / 2));
            if(seasonsNumber.offsetHeight > (screen.height / 2)){
            seasonsNumber.style.maxHeight = (screen.height) + "px";
            }else{
            seasonsNumber.style.maxHeight = (screen.height / 1.5) + "px";
            }
        }

            episodiData.forEach(episodio => {
                var episodioDiv = document.createElement("div");
                episodioDiv.id = "ep." + episodio["number"];
                if(window.innerWidth <= 500){
                    episodioDiv.className = "card w-100 p-2 d-flex justify-content-center align-items-center";
                }else {
                    episodioDiv.className = "card w-100 m-4";
                }
                episodioDiv.style = "width: 15rem;";
                if(episodio["image"] != null){
                    episodioDiv.innerHTML = '<img src="' + episodio["image"]["medium"] + '" class="card-img-top" alt="Episodio ' + episodio["number"] + '">';
                }
    
                var episodioDiv2 = document.createElement("div");
                episodioDiv2.className = "card-body";
                episodioDiv2.dataset.episodioNumero = episodio["number"];
                if(episodio["summary"] != null){
                    episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                '<p class="card-text">' + episodio["summary"] + '</p>' + '<a class="btn btn-primary" >Guarda</a>';
                }else {
                    episodioDiv2.innerHTML = '<h5 class="card-title">' + episodio["name"] + '</h5>' + 
                '<p class="card-text"></p>' + '<a class="btn btn-primary" >Guarda</a>';
                }
                episodioDiv.appendChild(episodioDiv2);
                if(window.innerWidth <= 500){
                    seasonsNumber.appendChild(episodioDiv);
                }else{
                    episodiSection.appendChild(episodioDiv);
                }
                
            }); 

    })
    .catch(error => {
        // La richiesta ha restituito un errore
        console.error(error.message);
    });

  })

}
}