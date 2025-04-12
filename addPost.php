<?php 
require_once 'inc/header.php' ;

if ($lang == 'ar') {
  $header_dir = 'text-right';
} else {
  $header_dir = 'text-left';
}

?>
<!-- Page Content -->
<!-- <div class="page-heading products-heading header-text"> -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-content">
          <h4>new Post</h4>
          <h2><?= $msg['Add New Post'] ?></h2>
        </div>
      </div>
    </div>
  </div>
<!-- </div> -->


<?php
// authorization validation
if(!isset($_SESSION['user_id'])){

  header("location:login.php");
}


?>
<div class="container w-50 ">
  <div class="d-flex justify-content-center">
    <h3 class="my-5"><?= $msg['Add New Post'] ?></h3>
  </div>
  <form method="POST" action="handle/handleAddPost.php" enctype="multipart/form-data">
    <div class="mb-3 <?=$header_dir?>">
      <label for="title" class="form-label"><?= $msg['Title'] ?></label>
      <input type="text" class="form-control <?=$header_dir?>" id="title" name="title" value="">
    </div>
    <?php
    if (isset($_SESSION['title_err'])) :
      foreach ($_SESSION['title_err'] as $title_err) :
    ?>
        <div  style="color:red; text-align:center"><?= $title_err ?></div>
    <?php endforeach;
    endif;
    unset($_SESSION['title_err']);
    ?>
    <div class="mb-3 <?=$header_dir?>">
      <label for="body" class="form-label"><?= $msg['Body'] ?></label>
      <textarea class="form-control <?=$header_dir?>" id="body" name="body" rows="5"></textarea>
    </div>
    <?php
    if (isset($_SESSION['body_err'])) :
      foreach ($_SESSION['body_err'] as $body_err) :
    ?>
        <div style="color:red; text-align:center"><?= $body_err ?></div>
    <?php endforeach;
    endif;
    unset($_SESSION['body_err']);
    ?>
    <div class="mb-3 <?=$header_dir?>">
      <label for="body" class="form-label"><?= $msg['image']?></label>
      <input type="file" class="form-control-file " id="image" name="image">
    </div>
    <?php
    if (isset($_SESSION['image_err'])) :
      foreach ($_SESSION['image_err'] as $image_err) :
    ?>
        <div style="color:red; text-align:center"><?= $image_err ?></div>
    <?php endforeach;
    endif;
    unset($_SESSION['image_err']);
    ?>

    <!-- <img src="uploads/<?php echo $post['image'] ?>" alt="" width="100px" srcset=""> -->
    <button type="submit" class="btn btn-primary d-flex" name="submit"><?= $msg['Add Post'] ?></button>
  </form>


</div>
</div>

<?php require_once 'inc/footer.php' ?>