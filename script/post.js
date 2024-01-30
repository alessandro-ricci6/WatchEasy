function likeUnlike() {
    $(".likeBtn").on("click", function() {
        let postId = $(this).attr("data-post-id");
        let icon = $(this).find("i");
        let likeNumber = this.querySelector(".likeNumber");
        if (icon.attr("class") == "fa-regular fa-heart") {
            icon.removeClass("fa-regular fa-heart").addClass("fa-solid fa-heart");

            fetch('./post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: "like",
                    postId: postId
                })
            })
            .then(response => {
                if (response.ok) {
                    return response.text(); // Parse the JSON from the response.
                } else {
                    throw new Error("Network response was not ok");
                }
            })
            .then(data => {
                likeNumber.innerHTML = data + ' ';
            })

        } else {
            icon.removeClass("fa-solid fa-heart").addClass("fa-regular fa-heart");
            fetch('./post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: "unlike",
                    postId: postId
                })
            })
            .then(response => {
                if (response.ok) {
                    return response.text(); // Parse the JSON from the response.
                } else {
                    throw new Error("Network response was not ok");
                }
            })
            .then(data => {
                likeNumber.innerHTML = data + ' ';
            })
        }
    });
}

$(document).ready(likeUnlike);