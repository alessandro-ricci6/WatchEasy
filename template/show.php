<link rel="stylesheet" href="style/show.css">

<?php

echo '<script type="text/javascript">';
echo 'const episodes = [];';

foreach ($templateParams['seasonNumber'] as $season) {
    foreach ($templateParams['season' . $season['number']] as $episode) {
        echo 'episodes.push({';
        echo 'name: "' . addslashes($episode['name']) . '",';
        echo 'image: "' . (isset($episode['image']['medium']) ? addslashes($episode['image']['medium']) : '') . '",';
        echo 'summary: "' . (isset($episode['summary']) ? addslashes($episode['summary']) : '') . '"';
        echo '});';
    }
}

echo '</script>';
?>

<?php $seasonsURL = "https://api.tvmaze.com/shows/" . $templateParams['showId'] . "/seasons"; ?>
<input class="form-control me-2" type="search" placeholder="Search the episode..." aria-label="Search" 
        style="position: fixed-top; padding: 10px; border: 2px solid black;"
        oninput="effettuaRicerca(event);">
<main>
  <div class="topDiv">
    <h1><?php echo $templateParams['showName'] ?></h1>
    <img class="showImg" src="<?php echo $templateParams['showImg'] ?>" alt="image" />
  </div>

  <div class="botDiv">
    <div class="summDiv">
      <?php echo $templateParams['summary'] ?>
      <?php if (!isSaved($templateParams['showId'], $templateParams['showSaved'])): ?>
        <button data-show-id="<?php echo $templateParams['showId'] ?>" type="button"
          class="btn btn-dark saveShowBtn border rounded">Save</button>
      <?php else: ?>
        <button data-show-id="<?php echo $templateParams['showId'] ?>" type="button"
          class="btn btn-light saveShowBtn border rounded">Remove</button>
      <?php endif; ?>
    </div>
    <div class="seasDiv">
      <div class="accordion">
        <?php foreach ($templateParams['seasonNumber'] as $season): ?>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="<?php echo '#collapse' . $season['number'] ?>" aria-expanded="true"
                aria-controls="<?php echo 'collapse' . $seaons['number'] ?>">
                <?php echo 'Season ' . $season['number'] ?>
              </button>
            </h2>
            <div id="<?php echo 'collapse' . $season['number'] ?>" class="accordion-collapse collapse">
              <div class="accordion-body">
                <ol>
                  <?php foreach ($templateParams['season' . $season['number']] as $episode):?>
                    <li>
                      <div class="epCard">
                        <h4><?php echo $episode['name'] ?></h4>
                        <h5><?php if($episode["image"] != null){
                                    echo ' <img src="' . $episode["image"]["medium"] . '" class="card-img-top" style="max-height: 300px; max-width:300px" alt="Episodio ' . $episode["number"] . '"> '; 
                                  }     
                        ?></h5>
                        <p><?php if($episode["summary"] != null){
                                    echo $episode['summary'];
                                  }
                        ?></p>
                        <?php if (!isSaved($episode['id'], $templateParams['epSaved'])): ?>
                          <button type="button" class="btn btn-dark saveEpBtn" data-ep-id="<?php echo $episode['id'] ?>">
                            Save episode
                          </button>
                        <?php else: ?>
                          <button type="button" class="btn btn-light saveEpBtn" data-ep-id="<?php echo $episode['id'] ?>">
                            Remove episode
                          </button>
                        <?php endif; ?>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ol>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <script src="script/show.js"></script>
</main>