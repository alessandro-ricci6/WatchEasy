function openPopup() {
  document.getElementById("popup").style.display = "block";
}

function closePopup() {
  document.getElementById("popup").style.display = "none";
}

document.getElementById("search-input").addEventListener("click", openPopup);
document.getElementById("search-input").addEventListener("blur", closePopup);

function searchSeries(value) {
    // Invia la richiesta Ajax
    $.get("https://api.tvmaze.com/search/shows?q=" + value, function(data) {
      console.log(data);
      console.log(data.length);
  
      const len = data.length < 10 ? data.length : 10;
  
      for (let i = 0; i < len; i++) {
        $("#results").append("<li>" + "<a href='#'>" + data[i]["show"]['name'] + "</a></li>");
      }
    });
  }
  
  $(document).ready(function() {
    $("#search-input").on("keyup", function() {
      // Invia la richiesta Ajax
      $("#results").empty();
      searchSeries(this.value);
    });
  });
  