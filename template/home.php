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

<!-- Modal to create post-->
<div class="modal" id="addPostModal" tabindex="-1" aria-hidden="true">
  <?php echo require 'createPost.php' ?>
</div>

<main class="float-md-start col-md-7">
    <div class="d-flex flex-column justify-content-center mx-4 px-3" id="postContainer">
        <?php require 'lista-post.php';?>
    </div>
</main>
