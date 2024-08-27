window.onload = () => {
    const button = document.getElementById('follow');
    button.addEventListener('click', function(event){
        var visitId = $("#visitId").val();

        $.ajax({
            url: 'addFollower.php',
            type: 'POST',
            data: {
                visit: visitId 
            }
        });
        
        if(button.classList.contains('clicked')){
            button.classList.remove('clicked');
            button.innerText = 'Follow';
        } else {
            button.classList.add('clicked');
            button.innerText = 'Followed';
        
        }
    })

}
