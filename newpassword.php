<?php
require_once "inc/header.php";

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
                        <div class="card-body pb-2">
                            <?php if (isset($_SESSION['success'])) :
                                foreach ($_SESSION['success'] as $success) :
                            ?>
                                    <div class="container text-center">
                                        <div class="text-info"><?= $success ?></div>
                                    </div>
                            <?php
                                endforeach;
                            endif;
                            unset($_SESSION['success']);
                            ?>

                            <h2 class="text-uppercase text-center mb-5">New Password</h2>

                            <form action="handle/handlenewpassword.php" method="post">
                                <div class="form-outline mb-4 <?=$header_dir?>">
                                    <label class="form-label" for="form3Example3cg"><?=$msg['Password']?></label>
                                    <input name="password" type="password" id="form3Example3cg" class="form-control form-control-lg text-left" />
                                </div>
                                <div class="form-outline mb-4 <?=$header_dir?>">
                                    <label class="form-label" for="form3Example3cg"><?=$msg['Password Confirmation']?></label>
                                    <input name="password_conf" type="password" id="form3Example3cg" class="form-control form-control-lg text-left" />
                        
                                </div>
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
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="confirm"
                                        class="btn btn-danger btn-lg gradient-custom-4">Confirm</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require 'inc/footer.php' ?>