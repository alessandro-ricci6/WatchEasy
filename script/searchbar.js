
function searchShows(query) {
    fetch(`https://api.tvmaze.com/search/shows?q=${query}`)
        .then(response => response.json())
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

function displayResults(shows) {
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = '';
    shows.forEach(item => {
        const show = item.show;
        const showElement = document.createElement('div');
        showElement.className = 'show';

        const showImage = document.createElement('img');
        showImage.src = show.image ? show.image.medium : 'https://via.placeholder.com/210x295?text=No+Image';
        showElement.appendChild(showImage);

        const showName = document.createElement('div');
        showName.className = 'name';
        

        const showURL = document.createElement('a');
        showURL.href=show.url;
        showURL.textContent = show.name;


        showName.appendChild(showURL);
        showElement.appendChild(showName);

        resultsContainer.appendChild(showElement);
    });
} 
window.onload = () => {
    const searchElement = document.getElementById('search-input');
    document.getElementById('button').addEventListener('click', function(event) {
        const query = document.getElementById('search-input').value;
        if (query) {
            searchShows(query);
        }
});
  
}

