<?php
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


if (isset($_POST['confirm']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    // fetch data
    $password = trim(htmlspecialchars($_POST['password']));
    $password_conf = trim(htmlspecialchars($_POST['password_conf']));

    //fetch sessions
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    
    //error arrays
    $password_err = [];


    //check if email exist
    $select_query = "SELECT * FROM `users` WHERE `id` = '$user_id' AND `email` = '$email'";
    $select_result = mysqli_query($conn, $select_query);
    if (empty($password) || empty($password_conf)) {
        $password_err[] = $msg['Password required'];
    }elseif($password !== $password_conf){
        $password_err[] = $msg['Two passwords not identical'];
    }
  
    if (empty($password_err)) {
        $password =  password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE `users` SET `password` = '$password' , `code` = '0' WHERE `id` = '$user_id'";
        $res = mysqli_query($conn, $update_query);
        if($res){
            unset($_SESSION['email']);
            unset($_SESSION['user_id']);
            $_SESSION['success'] = [$msg["Password Reset Successfully , Please Login "]];
            header("location:../login.php");
        }
    } else {
        $_SESSION['password_err'] = $password_err;
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
