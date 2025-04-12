<?php
require_once "inc/conn.php";

if (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
} else {
  $lang = "en";
}

if ($lang == 'ar') {
  require_once "ar.php";
  $dir = "rtl";
} else {
  require_once "en.php";
  $dir = "ltr";

}

?>

<!DOCTYPE html>
<html lang="en" dir="<?=$dir?>">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <title><?= $msg['blog'] ?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--

    TemplateMo 546 Sixteen Clothing

    https://templatemo.com/tm-546-sixteen-clothing

    -->

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
  <link rel="stylesheet" href="assets/css/owl.css">

</head>

<body>

  <!-- ***** Preloader Start ***** -->
  <!-- <div id="preloader" >
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>   -->
  <!-- ***** Preloader End ***** -->

  <!-- Header -->
  <header class="padding-0">
    <nav class="navbar navbar-expand-lg ">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <h2> <em><?= $msg['ALfawakhry blog'] ?></em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <?php 
          if($lang == 'ar'){
            $nav_m = 'mr-auto';
          }else{
            $nav_m = 'ml-auto';
          }
          ?>



          <?php 
          $curr_page = basename($_SERVER['PHP_SELF']);
          
          
          ?>
          <ul class="navbar-nav <?=$nav_m?>">
            <li class="nav-item <?=$curr_page == 'index.php'?'active':''?>">
              <a class="nav-link" href="index.php"><?= $msg['All Posts'] ?>
                <span class="sr-only">(current)</span>
              </a>
            </li>

            <li class="nav-item <?=$curr_page == 'myposts.php'?'active':''?>">
              <a class="nav-link" href="myposts.php"><?= $msg['My Posts'] ?>
                <span class="sr-only">(current)</span>
              </a>
            </li>

            <?php
            if (isset($_SESSION['user_id'])):
            ?>
              <li class="nav-item <?=$curr_page == 'addPost.php'?'active':''?>">
                <a class="nav-link" href="addPost.php"><?= $msg['Add New Post'] ?></a>
              </li>
            <?php else: ?>
              <li class="nav-item <?=$curr_page == 'register.php'?'active':''?>">
                <a class="nav-link" href="register.php"><?= $msg['Create Account'] ?></a>
              </li>
            <?php endif; ?>

            <?php if($lang=='ar'): ?>
            <li class="nav-item">
              <a class="nav-link" href="inc/changeLang.php?lang=en">English</a>
            </li>
            <?php else:?>
            <li class="nav-item">
              <a class="nav-link" href="inc/changeLang.php?lang=ar">العربية</a>
            </li>
  <?php endif;?>
            <?php
            if (isset($_SESSION['user_id'])):
            ?>

              <li class="nav-item <?=$curr_page == 'profile.php'?'active':''?>">
                <a class="nav-link" href="profile.php"><?= $msg['Profile']?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="handle/handleLogout.php"><?= $msg['Logout'] ?></a>
              </li>
            <?php else: ?>
              <li class="nav-item <?=$curr_page=='login.php' ? 'active': "" ?>">
                <a class="nav-link" href="login.php"><?= $msg['Login'] ?></a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>