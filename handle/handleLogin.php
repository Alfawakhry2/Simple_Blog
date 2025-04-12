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


if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    // fetch data
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    //error arrays
    $email_err = [];
    $password_err = [];


    //check if email exist
    $select_query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $select_result = mysqli_query($conn, $select_query);
    $user = mysqli_fetch_assoc($select_result);
    if (empty($email)) {
        $email_err[] = $msg['Email required'];
    } elseif (mysqli_num_rows($select_result) == 0) {
        $email_err[] =$msg['account not correct'] ;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err[] = $msg['Incorrect email'];
    } else {
        //check password
        $db_password = $user['password'];
        $verify = password_verify($password, $db_password);
        if (!$verify) {
            $password_err[] =$msg["Password incorrect"] ;
        } elseif (empty($password)) {
            $password_err[] =$msg["Password required"] ;
        }
    }




    if ($verify && empty($email_err) && empty($password_err)) {
        $user_id = $user['id'];
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $email;
        header("location:../index.php");
    } else {
        $_SESSION['email_err'] = $email_err;
        $_SESSION['password_err'] = $password_err;
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}
