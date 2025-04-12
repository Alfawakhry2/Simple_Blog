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


if (isset($_POST['otp']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    // fetch data
    $code = trim(htmlspecialchars($_POST['code']));
    $email = $_SESSION['email'];
    //error arrays
    $otp_err = [];

    //check if email exist
    $select_query = "SELECT * FROM `users` WHERE `email` = '$email' AND  `code` = '$code'";
    $select_result = mysqli_query($conn, $select_query);
    $user = mysqli_fetch_assoc($select_result);
    if (empty($code)) {
        $otp_err[] = $msg["Code required"];
    } elseif (mysqli_num_rows($select_result) == 0) {
        $otp_err[] =$msg["Code Not Correct"];
    }

    if (empty($otp_err) && mysqli_num_rows($select_result) == 1){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email ; 
        header("location:../newpassword.php");
    } else {
        $_SESSION['otp_err'] = $otp_err ; 
        header("location:../otp.php");
    }
} else {
    header("location:../login.php");
}
