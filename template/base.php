<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title><?php echo $templateParams['titolo']; ?></title>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand navbar-expand-lg bg-dark">
            <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <button class="menuBtn me-auto mb-2 mb-lg-0 btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    <span class="fa-solid fa-bars"></span>
                </button>
                <h1 class="mx-3"><a class="text-decoration-none text-light" href="index.php">WatchEasy</a></h1>
                <button type="button" class="btn btn-dark me-2 position-relative border border-1" data-bs-toggle="modal" data-bs-target="#notificationModal">
                  <span class="fa-solid fa-envelope"></span>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCounter">
                    <?php echo mysqli_num_rows($db->getActiveNotification(3)); ?>
                    <span class="visually-hidden">unread messages</span>
                  </span>
                </button>
                
              </div>
            </div>
          </nav>
    </header>

    <!-- Menu -->
    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
      <div class="offcanvas-header bg-dark">
        <h2 class="offcanvas-title text-light" id="staticBackdropLabel">Menu</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body bg-dark">
        <div>
          <nav class="menu">
            <ul class="list-unstyled px-3">
              <li class="pt-2"><a <?php isActive("index.php"); ?> href="index.php">Home</a></li>
              <li class="pt-2"><a <?php isActive("profile.php"); ?> href="profile.php?username=user3">Profilo</a></li>
              <li class="pt-2"><a <?php isActive("feed.php"); ?> href="feed.php">Feed</a></li>
            </ul>
          </nav>
          
        </div>
      </div>
      <div class="bg-dark d-flex justify-content-center">
        <a class="text-danger link-underline link-underline-opacity-0 bg-dark pb-2" href="#">Log Out</a>
      </div>
    </div>

    <?php if($templateParams['nome']=='lista-post.php'):?>
    <!-- Aside with User search bar and Add a post button -->
    <aside class="col-md-3 px-3 pt-1 m-3 float-md-end sticky-md-top d-flex justify-content-center">
      <div class="text-center">
        <div class="userDiv border rounded">
          <label for="searchUser" class="px-2 py-1">Search user:<br><input type="text" name="searchUser" id="searchUser"></label>
          <div id="searchPopup">
          </div>
        </div>
        <button type="button" class="btn btn-dark my-4" data-bs-toggle="modal" data-bs-target="#addPostModal">Add review</button>
      </div>
    </aside>
    <?php endif; ?>

      <?php
      if(isset($templateParams['nome'])){
          require($templateParams['nome']);
      }
      ?>

    <div class="modal" id="addPostModal" tabindex="-1" aria-hidden="true">
      <?php echo require 'createPost.php' ?>
    </div>

    <!-- Modal opened when press Notification button -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
      <?php require 'notification-view.php'; ?>
    </div>

</body>
</html>