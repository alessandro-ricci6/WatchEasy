function createPost() {
    $("#createPostForm").on("submit", function(event) {
        event.preventDefault();
        const formData = new FormData($(this)[0])
        const accType = ["png", "jpg", "jpeg"]
        const ext = formData.get("uploadImg").name.split('.').pop();
        if (accType.includes(ext) || formData.get("uploadImg").name == ""){
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

$(document).ready(createPost);