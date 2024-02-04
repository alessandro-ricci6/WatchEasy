function likeUnlike() {
    $(".likeBtn").on("click", function() {
        let postId = $(this).attr("data-post-id");
        let icon = this.querySelector(".likeIcon");
        let likeNumber = this.querySelector(".likeNumber");
        const creatorId = $(this).attr("data-creator-id");
        if (icon.classList.contains("fa-regular")) {          

            fetch('./post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: "like",
                    creatorId: creatorId,
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
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid");
            })
        } else {
            fetch('./post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: "unlike",
                    creatorId: creatorId,
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
                icon.classList.remove("fa-solid");
                icon.classList.add("fa-regular");
            })
        }
    });
}

function addComment() {
    $(".addCommentBtn").on("click", function() {
        const postId = $(this).attr("data-post-id");
        const creatorId = $(this).attr("data-creator-id");
        let commentText = document.getElementById("commentTextArea" + postId).value;
        fetch('./post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'comment',
                postId: postId,
                creatorId: creatorId,
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

function deletePost() {
    $(".popoverPost").on("shown.bs.popover", function() {
        const postId = $(this).attr("data-post-id");
        $(".deleteBtn").on("click", function() {
            fetch( "./post.php", {
                method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'delete',
                postId: postId
                })
            })
            .then(response => {
                if (response.ok) {
                    const post = document.getElementById("cardPost" + postId);
                    document.getElementById("postContainer").removeChild(post);
                    return response.text(); // Parse the JSON from the response.
                } else {
                    throw new Error("Network response was not ok");
                }
            })
        })
    })
}

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
  });
$(document).ready(deletePost)
$(document).ready(addComment);
$(document).ready(likeUnlike);