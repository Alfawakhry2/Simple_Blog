<?php
require_once 'inc/header.php';
require_once "inc/conn.php";

if ($lang == 'ar') {
  $header_dir = 'text-right';
} else {
  $header_dir = 'text-left';
}


?>

<!-- Page Content -->
<div class="page products-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-content">
          <h4>new Post</h4>
          <h2>add new personal post</h2>
        </div>
      </div>
    </div>
  </div>
</div>

<?php


if(isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM `posts` WHERE `id` = '$id'";
  $res = mysqli_query($conn, $query);
  $row_count = mysqli_num_rows($res);
  if ($row_count == 1) {
    $post = mysqli_fetch_assoc($res);
  } else {
    header("location:index.php");
  }
}else {
  header("location:index.php");
}

?>
<div class="best-features about-features">
  <div class="container">
    <?php
    if (isset($_SESSION['success'])) :
      foreach ($_SESSION['success'] as $success) :
    ?>
        <div class="alert alert-info text-capitalize" style="text-align:center"><?= $success ?></div>
    <?php
      endforeach;
    endif;
    unset($_SESSION['success']);
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="section-heading <?=$header_dir?>">
          <h2><?=$msg['Post Details']?></h2>
        </div>
      </div>
      <div class="col-md-6">
        <div class="right-image img-thumbnail">
          <img src="assets/images/postImage/<?= $post['image'] ?>" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="left-content">
          <h2 class="text-capitalize"><?= $post['title'] ?></h2>
          <p class="ml-2"><?= $post['body'] ?></p>
          <p><?= $post['created_at'] ?></p>
          <?php 

          // means that user can only edit or delete its post
          // the second condation mean if any one login can edit in any post of any user  
          if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']):
          ?>
          <div class="d-flex justify-content-center ">
            <a href="editPost.php?id=<?= $id ?>" class="btn btn-success mr-3 text-capitalize"><?=$msg['Edit Post']?></a>
            <div class="mx-3"> 
              <form action="handle/handleDeletePost.php" method="Post">
                <a href="handle/handleDeletePost.php?id=<?= $id ?>" ></a>
                <input type="hidden" name="id" value="<?=$id?>" >
                <input type="submit" value="<?=$msg['Delete Post']?>" class="btn btn-danger text-capitalize" >
              </form> 
            </div>
          </div>
          <?php
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'inc/footer.php' ?>