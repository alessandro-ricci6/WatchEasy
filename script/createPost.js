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

function createPost() {
    $("#createPostForm").on("submit", function(event) {
        event.preventDefault();
        const formData = new FormData($(this)[0])
        const accType = ["png", "jpg", "jpeg"]
        const ext = formData.get("uploadImg").name.split('.').pop();
        if (accType.includes(ext)){
            $.ajax({
                url: "create-post.php",
                method: "POST",
                action: "createPost",
                processData: false,
                contentType: false,
                data: formData,
                success: function() {
                    document.getElementById("createPostForm").reset();
                    alert("Post caricato correttamente");
                }
            })
        } else {
            alert("Formato non accettato (Solo png, jpeg, jpg)");
        }
        
    })
}

$(document).ready(changeEpisode);
$(document).ready(changeSeason);
$(document).ready(createPost);