    function follow() {

        $(document).ready(function() {
            $("#followButton").click(function() {
                
                var visitId = $("#visitId").val();
        
                $.ajax({
                    url: 'addFollower.php',
                    type: 'POST',
                    data: {
                        visit: visitId 
                    }
                });
            });
        });
        
        var button = document.getElementById('follow');
        if(button.classList.contains('clicked')){
            button.classList.remove('clicked');
            button.innerText = 'Follow';
        } else {
            button.classList.add('clicked');
            button.innerText = 'Followed';

            $(document).ready(function() {
                $("#followButton").click(function() {
                    
                    var visitId = $("#visitId").val();
            
                    $.ajax({
                        url: 'addFollower.php',
                        type: 'POST',
                        data: {
                            visit: visitId 
                        }
                    });
                });
            }); 
        }
        

        
    }
    
            button.innerText = 'Follow';
        } else {
            button.classList.add('clicked');
            button.innerText = 'Followed';
        }
        

        
    }
    
    