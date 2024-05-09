function follow() {
    $(document).ready(function() {
        $("#followButton").click(function() {
            var visitId = $("#visitId").val();
            $.ajax({
                url: 'addFollower.php',
                type: 'POST',
                data: {
                    visit: visitId 
                },
                success: function(response) {
                    // Handle success response here if needed
                    toggleButton();
                },
                error: function(xhr, status, error) {
                    // Handle error here if needed
                }
            });
        });
    });
}

function toggleButton() {
    var button = $("#followButton");
    if(button.hasClass('clicked')){
        button.removeClass('clicked');
        button.text('Follow');
    } else {
        button.addClass('clicked');
        button.text('Followed');
    }
}