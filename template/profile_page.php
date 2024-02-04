    <div>
        <img src="download.jpg" alt="foto profilo" >  
        <p><?php echo $templateParams['nome']; ?></p>
        <button id="follow"> Follow </button>
    </div>
    <nav>
      <table id="first">
            <tr>
            <th>Follower</th>
            <th>Seguiti</th>
            <th>Post</th>
            </tr>
            <tr>
                <td><?php echo $templateParams['follower']; ?></td>
                <td><?php echo $templateParams['followed']; ?></td>
                <td><?php echo $templateParams['numpost']; ?></td>
            </tr>
        </table>
        <table id="second">
            <tr>
            <th>Serie viste</th>
            <th>Episodi Visti</th>
            </tr>
            <tr>
                <td> <?php echo count($templateParams['show']) ?></td>
                <td> <?php echo $templateParams['totepisode'] ?></td>
            </tr>
        </table>
    </nav>
    <main>
    <section>
        <h1>Serie Tv</h1>
        <div id="tab_img">
            <?php foreach($templateParams['show'] as $show):?>
                <img src="<?php echo $api->getTvShowById($show['showId'])['image']['medium'] ?>" alt="">
            <?php endforeach; ?>
        </div>
    </section>
    <article>
      <h1>Post</h1>
        <?php require 'lista-post.php' ?>
        </article>
    <footer>
        <form action="#" method="get">
            <input type="button" value="+" id="post" onclick="">
            <label for="post">Aggiungi Post</label>
        </form>
    </footer>