    function follow() {
        
        var button = document.getElementById('follow');
        if(button.classList.contains('clicked')){
            button.classList.remove('clicked');
            button.innerText = 'Follow';
        } else {
            button.classList.add('clicked');
            button.innerText = 'Followed';
        }
        

        
    }
    
    