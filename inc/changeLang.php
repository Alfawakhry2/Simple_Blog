<?php 
require_once "conn.php";

if(isset($_GET['lang'])){
    $lang = $_GET['lang'];
}

if($lang == "ar"){
    $_SESSION['lang'] = "ar";
}else{
    $_SESSION['lang'] = "en";
}

//عشان لما يضغط على عربي او انجليزي من صفحه تسجيل الدخول مثلا ف يحول لعربي ويرجعلها تاني بدون منكتب اسم الصفحه 
header("location:".$_SERVER['HTTP_REFERER']);

?>