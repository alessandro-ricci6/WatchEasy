
    var button = document.getElementById('follow');

    button.addEventListener('click', function() {
        button.classList.add('clicked');

        button.textContent = 'Followed';

        disableClick(function() {
            button.classList.remove('clicked');
            button.textContent = 'Follow';
          
        });
    })
    