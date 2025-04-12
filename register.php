<?php 
require_once "inc/header.php";
if(isset($_SESSION['user_id'])){
  header("location:index.php");
  exit();
}
if ($lang == 'ar') {
    $header_dir = 'text-right';
} else {
    $header_dir = 'text-left';
}
?>

<br><br><br><br>
<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-6">
              <h2 class="text-uppercase text-center mb-5"><?=$msg['Create Account']?></h2>

              <form action="handle/handleRegister.php" method="post">
                <!-- name -->
                <div class="form-outline mb-4 <?=$header_dir?>">
                <label class="form-label" for="form3Example3cg"><?=$msg['Name']?></label>
                  <input name="name" type="text" id="form3Example3cg" class="form-control form-control-lg text-left" />
                  <?php if (isset($_SESSION['name_err'])) :
                foreach ($_SESSION['name_err'] as $name_err) :
            ?>
                    <div class="container text-center">
                        <div class="text-danger"><?= $name_err ?></div>
                    </div>
            <?php
                endforeach;
            endif;
            unset($_SESSION['name_err']);
            ?>
                </div>
                <!-- email -->
                <div class="form-outline mb-4 <?=$header_dir?>">
                  <label class="form-label" for="form3Example4cg"><?=$msg['Email']?></label>
                  <input name="email" type="email" id="form3Example4cg" class="form-control form-control-lg text-left"/>
                  <?php if (isset($_SESSION['email_err'])) :
                foreach ($_SESSION['email_err'] as $email_err) :
            ?>
                    <div class="container text-center">
                        <div class="text-danger"><?= $email_err ?></div>
                    </div>
            <?php
                endforeach;
            endif;
            unset($_SESSION['email_err']);
            ?>
                </div>
                <!-- password -->
                <div class="form-outline mb-4 <?=$header_dir?>">
                  <label class="form-label" for="form3Example4cg"><?=$msg['Password']?></label>
                  <input name="password" type="password" id="form3Example4cg" class="form-control form-control-lg text-left"/>
                </div>
                <!-- password conf -->
                <div class="form-outline mb-4 <?=$header_dir?>">
                  <label class="form-label" for="form3Example4cg"><?=$msg['Password Confirmation']?></label>
                  <input name="password_conf" type="password" id="form3Example4cg" class="form-control form-control-lg text-left"/>
                  <?php if (isset($_SESSION['password_err'])) :
                foreach ($_SESSION['password_err'] as $password_err) :
            ?>
                    <div class="container text-center">
                        <div class="text-danger"><?= $password_err ?></div>
                    </div>
            <?php
                endforeach;
            endif;
            unset($_SESSION['password_err']);
            ?>
                </div>

                <!-- phone -->
                <div class="form-outline mb-4 <?=$header_dir?>">
                  <label class="form-label" for="form3Example4cg"><?=$msg['Phone']?></label>
                  <input name="phone" type="text" id="form3Example4cg"  class="form-control form-control-lg text-left" />
                  <?php if (isset($_SESSION['phone_err'])) :
                foreach ($_SESSION['phone_err'] as $phone_err) :
            ?>
                    <div class="container text-center">
                        <div class="text-danger"><?= $phone_err ?></div>
                    </div>
            <?php
                endforeach;
            endif;
            unset($_SESSION['phone_err']);
            ?>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit" name="register" 
                    class="btn  btn-danger btn-lg gradient-custom-4" ><?=$msg['Create Account']?>
                  </button>
                </div>
                <div style="color:green; text-align:center"><?= (isset($succ))?$succ:''?></div>
                <p class="text-center text-muted mt-5 mb-0"><?=$msg['Have Account ?']?><a href="login.php"
                    class="fw-bold text-body"><u> <?=$msg['Login']?></u></a></p>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php  require 'inc/footer.php'?>

















<!-- my part -->
