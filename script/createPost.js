function changeSeason() {
    $("#showSelect").on("change", function() {
        const showId = $(this).val();
        const seasonSelector = document.getElementById("seasonSelect");
        $.ajax({
            url: "show.php",
            method: "GET",
            data: {
                action: "getSeason",
                showId: showId
            },
            success: function(data) {
                const jsonData = JSON.parse(data);
                seasonSelector.removeAttribute("disabled");
                $("#seasonSelect").empty();
                seasonSelector.append(new Option("", ""));
                for (const season of jsonData){
                    const option = new Option(season.seasonNumber, season.seasonId);
                    seasonSelector.append(option);
                }
            }
        })
    })
}

function changeEpisode() {
    $("#seasonSelect").on("change", function() {
        const seasonId = $(this).val();
        const episodeSelector = document.getElementById("episodeSelect");
        $.ajax({
            url: "show.php",
            method: "GET",
            data: {
                action: "getEpisode",
                seasonId: seasonId
            },
            success: function(data) {
                const jsonData = JSON.parse(data);
                episodeSelector.removeAttribute("disabled");
                $("#episodeSelect").empty();
                episodeSelector.append(new Option("", ""));
                for (const episode of jsonData){
                    const option = new Option(episode.episodeNumber, episode.episodeId);
                    episodeSelector.append(option);
                }
            }
        })
    })
}
$(document).ready(changeEpisode);
$(document).ready(changeSeason);