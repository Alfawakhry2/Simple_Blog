<?php 
require_once "inc/header.php";



if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

?>


<!-- get user data -->
<?php 
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM `users` WHERE `id` = '$user_id'";
$res = mysqli_query($conn , $query);
if(mysqli_num_rows($res) == 1){
    $user_data = mysqli_fetch_assoc($res);

    $query2 = "SELECT * FROM `posts` WHERE `user_id` = '$user_id'";
    $res2 = mysqli_query($conn , $query2);
    $post_nums = mysqli_num_rows($res2);
}
?>
<!-- end get user data -->
<br><br><br>
<div>
  <section style="background-color: #eee;">
    <div class="container py-5">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item active" aria-current="page"><?=$msg['User Profile']?></li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <img src="assets/images/client-01.png" alt="profile photo" class="rounded-circle img-fluid" style="width: 150px;">
              <h5 class="my-3"></h5>
              <p class="text-muted mb-1">Full Stack Developer</p>
              <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">

            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><?=$msg['Name']?></p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?=$user_data['name']?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><?=$msg['Email']?></p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?=$user_data['email']?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><?=$msg['Identification Number']?></p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?=$user_data['id']?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"><?=$msg['Number of Posts']?></p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?=$post_nums?></p>
                </div>
              </div>
              <div class="d-flex justify-content-center mb-2 mt-2 ">
                <a href="myposts.php"><button type="button" class="btn btn-danger ms-1 "><?=$msg['Show My Posts']?></button></a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>


<?php require 'inc/footer.php' ?>