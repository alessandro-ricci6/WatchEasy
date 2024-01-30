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

function addComment() {
    $(".addCommentBtn").on("click", function() {
        const postId = $(this).attr("data-post-id");
        let commentText = document.getElementById("commentTextArea" + postId).value;
        fetch('./post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'comment',
                postId: postId,
                commentText: commentText
            })
        })
        .then(response => {
            if (response.ok) {
                return response.text(); // Parse the JSON from the response.
            } else {
                throw new Error("Network response was not ok");
            }
        })
        .then (data => {
            jsonData = JSON.parse(data)
            console.log(jsonData.username)
            let comment = document.createElement("li");
            let link = document.createElement("a");
            link.href = "profile.php?username=" + jsonData.username;
            link.innerText = jsonData.username + ": ";
            let paragraph = document.createElement("p");
            paragraph.innerHTML = commentText;

            comment.appendChild(link);
            comment.appendChild(paragraph);

            let commentList = document.getElementById("commentList" + postId);
            commentList.appendChild(comment);
            let commBtn = document.getElementById("commentBtn" + postId);
            commBtn.innerHTML = jsonData.numComment + " <i class='fa-regular fa-comment'></i>"
        })
    });
}

$(document).ready(addComment);
$(document).ready(likeUnlike);