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
            return response.text(); // Parse the JSON from the response.
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
            return response.text(); // Parse the JSON from the response.
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
            return response.text(); // Parse the JSON from the response.
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
                return response.text(); // Parse the JSON from the response.
              } else {
                throw new Error("Network response was not ok " + response);
              }
            });
      }
    });
  }
  
  $(document).ready(saveEpisode);
  $(document).ready(saveShow);
  