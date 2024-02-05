<main>
    <input type="text" id="search-input" placeholder="Cerca una serie TV">
    <div class="input-group mb-3">
      <button class="btn btn-outline-secondary" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
      </svg></button>
    </div>
    <section>
      <div>
      <h1>Suggested Post</h1>
      <!--div che contiene i post-->
      <?php require 'feed.php' ?>
        
    </div>
    </section>
  </main>