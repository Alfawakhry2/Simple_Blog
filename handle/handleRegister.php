<?php
require_once "../inc/conn.php";
// authorization validation
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


if (isset($_POST['register']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    // catch data 
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = $_POST['password'];
    $password_conf = $_POST['password_conf'];
    $phone = $_POST['phone'];

    // error arrays
    $name_err = [];
    $email_err = [];
    $password_err = [];
    $phone_err = [];

    // validation

    // name validation
    if (empty($name)) {
        $name_err[] = $msg["Name is required"];
    } elseif (is_numeric($name)) {
        $name_err[] = $msg["Name should be string"];
    } elseif (strlen($name) < 2) {
        $name_err[] = $msg["Name is too short , at least 2 characters"];
    }

    // email validation
    //check if email exist 
    $select_query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $select_result = mysqli_query($conn, $select_query);
    if (mysqli_num_rows($select_result) == 1) {
        $email_err[] = $msg["Email already exist"];
    } elseif (empty($email)) {
        $email_err[] = $msg["Email required"] ;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err[] =$msg["Incorect email , must be like (example@example.com)"] ;
    }


    //check Password
    if (empty($password) || empty($password_conf)) {
        $password_err[] = $msg["Password required"];
    } elseif ($password !== $password_conf) {
        $password_err[] = $msg["Two passwords not identical"];
    } elseif (strlen($password) < 6) {
        $password_err[] = $msg["Password is too short"];
    }
      
    //check phone
    $select_query2 = "SELECT * FROM `users` WHERE `phone` = '$phone'";
    $select_result2 = mysqli_query($conn, $select_query2);
    if (mysqli_num_rows($select_result2) > 0) {
        $phone_err[] = $msg["Phone already exist"];
    } elseif (empty($phone)) {
        $phone_err[] = $msg["Phone is required"];
    } elseif (strlen($phone) < 11 || strlen($phone) > 11) {
        $phone_err[] = $msg["phone Number is inncorrect"];
    }

    // if all things ok 
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($phone_err)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO `users`(`name`,`email`,`password`,`phone`) VALUES('$name','$email','$hashed_password','$phone')";
        $insert_result = mysqli_query($conn, $insert_query);
        if ($insert_result) {
            $_SESSION['success'] = [$msg["Account Created Successfully"]];
            header("location:../login.php");
        } else {
            $_SESSION['error'] = ["error while create account"];
            header("location:../register.php");
        }
    } else {
        $_SESSION['name_err'] = $name_err ; 
        $_SESSION['email_err'] = $email_err ;
        $_SESSION['password_err'] = $password_err ; 
        $_SESSION['phone_err'] = $phone_err ; 
        header("location:../register.php");
    }
} else {
    header("location:../register.php");
}
