<?php 
require_once "../inc/conn.php";
// authorization validation
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
}
if(isset($_POST['id'])){
    $id = $_POST['id'];

    $query = "SELECT * FROM `posts` WHERE `id` = '$id'";
    $res =mysqli_query($conn , $query) ;
    if(mysqli_num_rows($res) == 1){
        $post = mysqli_fetch_assoc($res);
        $oldImage = $post['image'];
        if(!empty($oldImage)){
            unlink("../assets/images/postImage/$oldImage");
        }
        $delete_query = "DELETE FROM `posts` WHERE `id` = '$id'";
        $result = mysqli_query($conn , $delete_query);
        if($result){
            $_SESSION['success'] = ['post deleted successfully . '];
            header("location:../myposts.php");
        }
    }else{
        $_SESSION['notfound'] = ['post not found'];
        header("location:../index.php");
    }
}else{
    header("location:../index.php");
}


?>