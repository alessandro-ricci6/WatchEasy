function saveShow() {
    $(".saveShowBtn").on("click", function () {
      const showId = $(this).attr("data-show-id");
      const saveBtn = $(this)[0];
      if (saveBtn.classList.contains("btn-dark")) {
        fetch("./show.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            showId: showId,
            action: "saveShow",
          }),
        }).then((response) => {
          if (response.ok) {
            saveBtn.innerHTML = "Remove";
            saveBtn.classList.remove("btn-dark");
            saveBtn.classList.add("btn-light");
            return response.text();
          } else {
            throw new Error("Network response was not ok");
          }
        });
      } else {
        fetch("./show.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            showId: showId,
            action: "delShow",
          }),
        }).then((response) => {
          if (response.ok) {
            saveBtn.innerHTML = "Add";
            saveBtn.classList.remove("btn-light");
            saveBtn.classList.add("btn-dark");
            return response.text();
          } else {
            throw new Error("Network response was not ok");
          }
        });
      }
    });
  }
  
  function saveEpisode() {
    $(".saveEpBtn").on("click", function () {
        const epId = $(this).attr("data-ep-id");
        const saveBtn = $(this)[0];

        if (saveBtn.classList.contains("btn-dark")) {
            fetch("./show.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    epId: epId,
                    action: "saveEpisode",
                }),
            }).then((response) => {
                if (response.ok) {
                    saveBtn.innerHTML = "Remove";
                    saveBtn.classList.remove("btn-dark");
                    saveBtn.classList.add("btn-light");
                    return response.text();
                } else {
                    throw new Error("Network response was not ok " + response);
                }
            });
        } else {
            fetch("./show.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    epId: epId,
                    action: "delEpisode",
                }),
            }).then((response) => {
                if (response.ok) {
                    saveBtn.innerHTML = "Add";
                    saveBtn.classList.remove("btn-light");
                    saveBtn.classList.add("btn-dark");
                    const index = savedEpisodes.indexOf(epId);
                    return response.text();
                } else {
                    throw new Error("Network response was not ok " + response);
                }
            });
        }
    });
}

  function isSaved(episodeId) {
    return savedEpisodes.includes(episodeId);
}

function effettuaRicerca(event) {
  const query = event.target.value.toLowerCase();
  const mainContent = document.querySelector('main');
  const resultsContainer = document.createElement('div');
  resultsContainer.className = 'search-results';
  resultsContainer.style.display = 'flex';
  resultsContainer.style.flexWrap = 'wrap';
  resultsContainer.style.justifyContent = 'center';
  resultsContainer.style.marginTop = '10px';

  const existingResults = document.querySelector('.search-results');
  if (existingResults) {
      existingResults.remove();
  }

  if (query === '') {
      mainContent.style.display = 'block';
      return;
  }

  mainContent.style.display = 'none';

  document.body.style.backgroundColor = 'white';

  episodes.forEach(function(episode) {
      if (episode.name.toLowerCase().includes(query)) {
          const episodeCard = document.createElement('div');
          episodeCard.className = 'epCard';
          episodeCard.style.margin = '10px';
          episodeCard.style.padding = '10px';
          episodeCard.style.border = '2px solid black';
          episodeCard.style.width = '200px';
          episodeCard.style.textAlign = 'center';

          const episodeTitle = document.createElement('h4');
          episodeTitle.textContent = episode.name;
          episodeCard.appendChild(episodeTitle);

          if (episode.image) {
              const episodeImage = document.createElement('img');
              episodeImage.src = episode.image;
              episodeImage.alt = "Episodio";
              episodeImage.className = 'full-width-image';
              episodeCard.appendChild(episodeImage);
          }

          const episodeSummary = document.createElement('p');
          episodeSummary.innerHTML = episode.summary;
          episodeCard.appendChild(episodeSummary);

          const saveButton = document.createElement('button');
          saveButton.type = 'button';
          saveButton.className = 'btn saveEpBtn';
          saveButton.textContent = isSaved(episode.id) ? 'Remove episode' : 'Save episode';
          saveButton.setAttribute('data-ep-id', episode.id);
          saveButton.classList.add(isSaved(episode.id) ? 'btn-light' : 'btn-dark');

          episodeCard.appendChild(saveButton);
          resultsContainer.appendChild(episodeCard);
      }
  });

  document.body.appendChild(resultsContainer);
  saveEpisode();
}

  
  $(document).ready(saveEpisode);
  $(document).ready(saveShow);
  