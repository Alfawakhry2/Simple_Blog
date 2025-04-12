<?php
 require_once 'inc/header.php';
 if ($lang == 'ar') {
  $header_dir = 'text-right';
} else {
  $header_dir = 'text-left';
}


 if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
}
 
 ?>
 <!-- Page Content -->
 <div class="page products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Edit Post</h4>
              <h2>edit your personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
require_once "inc/conn.php";
if(!isset($_GET['id'])){
  header("location:index.php");
}else{
  $id = $_GET['id'];
  $query = "SELECT * FROM `posts` WHERE `id` = '$id'";
  $res = mysqli_query($conn , $query);
  if(mysqli_num_rows($res) == 1){
    $post = mysqli_fetch_assoc($res);
  }else{
    header("location:index.php");
  }
}


?>

<div class="container w-50 ">
<div class="d-flex justify-content-center">
    <h3 class="my-5"><?=$msg['Edit Post']?></h3>
  </div>
    <form method="POST" action="handle/handleEditPost.php?id=<?=$id?>" enctype="multipart/form-data">
        <div class="mb-3 <?=$header_dir?>">
            <label for="title" class="form-label"><?=$msg['Title']?></label>
            <input type="text" class="form-control" id="title" name="title" value="<?=$post['title']?>">
        </div>
        <?php
          if (isset($_SESSION['title_err'])) :
            foreach ($_SESSION['title_err'] as $title_err) :
          ?>
              <div class="text-danger" style="text-align:center"><?= $title_err ?></div>
          <?php
            endforeach;
          endif;
          unset($_SESSION['title_err']);
          ?>
        <div class="mb-3 <?=$header_dir?>">
            <label for="body" class="form-label"><?=$msg['Body']?></label>
            <textarea class="form-control" id="body" name="body" rows="5"><?=$post['body']?></textarea>
        </div>
        <?php
          if (isset($_SESSION['body_err'])) :
            foreach ($_SESSION['body_err'] as $body_err) :
          ?>
              <div class="text-danger" style="text-align:center"><?= $body_err ?></div>
          <?php
            endforeach;
          endif;
          unset($_SESSION['body_err']);
          ?>
        <div class="mb-3 <?=$header_dir?>">
            <label for="body" class="form-label"><?=$msg['image']?></label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        <?php
          if (isset($_SESSION['image_err'])) :
            foreach ($_SESSION['image_err'] as $image_err) :
          ?>
              <div class="text-danger" style="text-align:center"><?= $image_err ?></div>
          <?php
            endforeach;
          endif;
          unset($_SESSION['image_err']);
          ?>
          <div class="d-flex mx-2">
            <img src="assets/images/postImage/<?=$post['image']?>" alt="" width="100px" srcset="">
          </div>
          <button type="submit" class="btn btn-primary d-flex m-2" name="update"><?=$msg['Edit Post']?></button>
        
    </form>
</div>


<?php require_once 'inc/footer.php' ?>