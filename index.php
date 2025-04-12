<?php
require_once 'inc/header.php';


?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="banner header-text">
  <!-- <div class="owl-banner owl-carousel"> -->
  <div class="owl owl-carousel">
    <div class="banner-item-01">
      <div class="text-content">
        <h4>Best Offer</h4>
        <h2>New Arrivals On Sale</h2>
      </div>
    </div>
    <div class="banner-item-02">
      <div class="text-content">
        <h4>Flash Deals</h4>
        <h2>Get your best products</h2>
      </div>
    </div>
    <div class="banner-item-03">
      <div class="text-content">
        <h4>Last Minute</h4>
        <h2>Grab last minute deals</h2>
      </div>
    </div>
  </div>
</div>
<!-- Banner Ends Here -->
<?php

if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}


$limit = 3;
// offset = limit * (n-1)\
$offset = ($page - 1) * $limit;

//to get number of posts
if (isset($_SESSION['user_id'])) {
  //if user has login and need to show timeline (will appear all without his posts)
  $user_id = $_SESSION['user_id'];
  $query0 = "SELECT * FROM `posts` WHERE `user_id` != '$user_id'";
  $res0 = mysqli_query($conn, $query0);

  // max to resolve the too many redirect
  $page_count = max(1, ceil((mysqli_num_rows($res0) / $limit)));


  if ($page > $page_count || $page <= 0) {
    header("location:index.php?page=1");
    exit();
  }
  // to get the posts 
  $query = "SELECT * FROM `posts` WHERE `user_id` != '$user_id' limit $limit offset $offset";
  $res = mysqli_query($conn, $query);
  $row_count = mysqli_num_rows($res);

  // if user enter without login show all posts 
} else {

  $query0 = "SELECT * FROM `posts`";
  $res0 = mysqli_query($conn, $query0);
  $page_count = max(1,ceil((mysqli_num_rows($res0) / $limit)));
  
  if ($page > $page_count || $page <= 0) {
    header("location:index.php?page=1");
    exit();
  }

  // to get the posts 
  $query = "SELECT * FROM `posts` limit $limit offset $offset";
  $res = mysqli_query($conn, $query);
  $row_count = mysqli_num_rows($res);
}


?>



<div class="latest-products">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="section-heading">
          <?php
          if (isset($_SESSION['notfound'])) :
            foreach ($_SESSION['notfound'] as $notfound) :
          ?>
              <div class="alert alert-danger text-capitalize" style="text-align:center"><?= $notfound ?></div>
          <?php
            endforeach;
          endif;
          unset($_SESSION['notfound']);
          ?>

          <?php
          if ($lang == 'ar') {
            $header_dir = 'text-right';
          } else {
            $header_dir = 'text-left';
          }
          ?>
          <h2 class="<?= $header_dir ?>"><?= $msg['Latest Posts'] ?></h2>
          <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
        </div>
      </div>
      <?php
      if ($row_count > 0) :
        $posts = mysqli_fetch_all($res, MYSQLI_ASSOC);
        foreach ($posts  as $post) :
      ?>
          <div class="col-md-4">
            <div class="product-item img-thumbnail">
              <a href="#"><img src="assets/images/postImage/<?= $post['image'] ?>" style="width: 340px;height: 180px;" alt=""></a>
              <a href="#">
                <h4 class="m-2 text-capitalize text-info"><?= $post['title'] ?></h4>
              </a>

              <h6 class="m-3 text-muted">Created at : <?= $post['created_at'] ?></h6>
              <div class="down-content">
                <div class="d-flex justify-content-end">
                  <a href="viewPost.php?id=<?= $post['id'] ?>" class="btn btn-info text-capitalize"><?= $msg['View'] ?></a>
                </div>
              </div>
            </div>
          </div>
        <?php
        endforeach;
      else :
        ?>
        <div class="">
          <h1 class="text-capitalize"><?= $msg['No Posts to display'] ?></h1>
        </div>
      <?php
      endif;
      ?>
    </div>
  </div>
</div>

<?php
if ($page_count > 1):
?>
  <div class="container">
    <nav>
      <ul class="pagination pagination-md justify-content-center">

        <?php
        if ($page > 1):
        ?>
          <li class="page-item"><a class="page-link" href="index.php?page=<?= $page - 1 ?>"><?= $msg['Previous'] ?></a></li>
        <?php endif; ?>

        <?php
        for ($i = 1; $i <= $page_count; $i++):
          $active = ($i == $page) ? 'active' : '';
        ?>
          <li class="page-item <?= $active ?>" aria-current="page">
            <a href="index.php?page=<?= $i ?>"><span class="page-link"><?= $i ?></span></a>
          </li>
        <?php endfor; ?>

        <?php
        if ($page < $page_count):
        ?>
          <li class="page-item"><a class="page-link" href="index.php?page=<?= $page + 1 ?>"><?= $msg['Next'] ?></a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
<?php

endif;
?>
<?php require_once 'inc/footer.php'; ?>