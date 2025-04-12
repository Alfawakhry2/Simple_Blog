<?php 
require_once "../inc/conn.php";

if(!isset($_SESSION['user_id'])){
    header("location:../index.php");
}else{
    
    unset($_SESSION['user_id']);
    header("location:../login.php");
}