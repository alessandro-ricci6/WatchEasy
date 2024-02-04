
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title><?php echo $templateParams['titolo']; ?></title>
</head>
<body>
    <header>
        <img src="download.jpg" alt="foto profilo" >  
        <p><?php echo $templateParams['nome']; ?></p>
        <button id="follow"> Follow </button>
    </header>
    <nav>
      <table id="first">
            <tr>
            <th>Follower</th>
            <th>Seguiti</th>
            <th>Post</th>
            </tr>
            <tr>
                <td> value, <?php echo $templateParams['follower']; ?></td>
                <td>value, <?php echo $templateParams['followed']; ?></td>
                <td>value, <?php echo $templateParams['numpost']; ?></td>
            </tr>
        </table>
        <table id="second">
            <tr>
            <th>Serie viste</th>
            <th>Episodi Visti</th>
            </tr>
            <tr>
                <td> <?php echo $templateParams['show']; ?></td>
                <td> <?php echo $templateParams['totepisode'] ?></td>
            </tr>
        </table>
    </nav>
    <main>
    <section>
        <h1>Serie Tv</h1>
        <div id="tab_img">
           <?php require 'utils/setImage.php' ?>
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
    </main>    
</body>
</html>