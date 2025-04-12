<?php
// included files and sessions 

require_once "../inc/conn.php";
if (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
} else {
  $lang = "en";
}

if ($lang == 'ar') {
  require_once "../inc/ar.php";
} else {
  require_once "../inc/en.php";
}


// authorization validation 

// not important cause 
// if(!isset($_SESSION['user_id'])){

//   header("location:login.php");
// }

// sure that method is post && sure that inputs safe
if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']=='POST'){
  $user_id = $_SESSION['user_id'] ; 
  $title = trim(htmlspecialchars($_POST['title']));
  $body = trim(htmlspecialchars($_POST['body']));

  // errors array of all forms
  $title_err = [] ;
  $body_err = [] ;
  $image_err = [] ;

  // validate the title 
  if(empty($title)){
    $title_err[] = $msg["The Post should have title"]; 
  }elseif(is_numeric($title)){
    $title_err[] =$msg["The title should be text"];
  }

  //validate the body
  if(empty($body)){
    $body_err[] = $msg["The Post should have body"];
  }elseif(is_numeric($body)){
    $body_err[] = $msg["The body should be text"];
  }

  //submit image and validate 
  if(isset($_FILES['image']) && $_FILES['image']['name']){

        // prepare the data of image
        $image = $_FILES['image'];
        $imageName=$image['name'];
        $tempImage = $image['tmp_name'];
        $imageSize = $image['size']/(1024*1024);
        $imageError = $image['error'] ;
        $allowed_extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];
        $imageExtension = strtolower(pathinfo($imageName , PATHINFO_EXTENSION));
        
        // validate image
        //$msg => related to languages (ar and en)
      if($imageSize == 0){
          $image_err [] = $msg["You should upload Image"]; 
        }elseif(!in_array($imageExtension , $allowed_extensions)){
            $image_err[]  = $msg["The allowed extension of image (jpg , jpeg , png , gif)"]; 
        }elseif($imageSize > 1){
            $image_err[] = $msg["The image is to large , should be less than (1mb)"];
        }elseif($imageError!= 0){
            $image_err[] =$msg["An error occour while upload image , try again"];
        }

        //move from temp to your path
        $newName = time().uniqid().".".$imageExtension;
    }else{
        $image_err [] = $msg["You should select image"];
    }
  //if all things ok 
  if(empty($title_err) && empty($body_err) && empty($image_err)){
    $query = "INSERT INTO `posts`(`title` , `body` , `image` , `user_id`) VALUES('$title' , '$body' , '$newName' , '$user_id')" ; 
    $res = mysqli_query($conn , $query);
    if($res){
        move_uploaded_file($tempImage , "../assets/images/postImage/$newName");
        $_SESSION['success'] = [$msg["Post Add Successfully."]] ;
        header("location:../myposts.php");
    }
  }else{
    $_SESSION['title_err'] = $title_err ; 
    $_SESSION['body_err'] = $body_err ; 
    $_SESSION['image_err'] = $image_err ;
    header("location:../addPost.php"); 
  }

}else{
    header("location:../addPost.php");
}


?>