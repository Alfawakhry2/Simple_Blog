<?php
require_once "../inc/conn.php";
// authorization validation

// get(post) and post(update button) 
if (isset($_POST['update']) && isset($_GET['id'])) {

    // fetch data
    $id = $_GET['id'];
    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));


    // take old image from database
    $query = "select * from `posts` where `id` = '$id'";
    $res = mysqli_query($conn, $query);
    if (mysqli_num_rows($res) == 1) {
        $post = mysqli_fetch_assoc($res);
        $oldImage = $post['image'];
    } else {
        header("location:../index.php");
    }

    //validate data 
    // errors array of all forms
    $title_err = [];
    $body_err = [];
    $image_err = [];

    // validate the title 
    if (empty($title)) {
        $title_err[] = "The Post should have title";
    } elseif (is_numeric($title)) {
        $title_err[] = "The title should be text";
    }

    //validate the body
    if (empty($body)) {
        $body_err[] = "The Post should have body";
    } elseif (is_numeric($body)) {
        $body_err[] = "The body should be text";
    }

    // validate image
    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        // prepare the data of image
        $newimage = $_FILES['image'];
        $imageName = $newimage['name'];
        $tempImage = $newimage['tmp_name'];
        $imageSize = $newimage['size'] / (1024 * 1024);
        $imageError = $newimage['error'];
        $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        // validate image
        if ($imageSize == 0) {
            $image_err[] = "You should upload Image";
        } elseif (!in_array($imageExtension, $allowed_extensions)) {
            $image_err[]  = "The allowed extension of image (jpg , jpeg , png , gif)";
        } elseif ($imageSize > 1) {
            $image_err[] = "The image is to large , should be less than (1mb)";
        } elseif ($imageError != 0) {
            $image_err[] = "An error occour while upload image , try again";
        }
        //move from temp to your path
        $newName = time() . uniqid() . "." . $imageExtension;
    } else {
        $newName = $oldImage;
    }


    if (empty($title_err) && empty($body_err) && empty($image_err)) {
        $update_query = "UPDATE `posts` SET `title` = '$title' , `body` = '$body' , `image` = '$newName' WHERE `id` = '$id'";
        $res = mysqli_query($conn, $update_query);
        if ($res) {
            if (isset($_FILES['image']) && $_FILES['image']['name']) {
                unlink("../assets/images/postImage/$oldImage");
                move_uploaded_file($tempImage, "../assets/images/postImage/$newName");
            }
            // put in array , can loop
            $_SESSION['success'] = ["Post Updated Successfully. "];
            header("location:../viewPost.php?id=$id");
        } else {
            header("location:../editPost.php?id=$id");
        }
    } else {
        $_SESSION['title_err'] = $title_err;
        $_SESSION['body_err'] = $body_err;
        $_SESSION['image_err'] = $image_err;
        header("location:../editPost.php?id=$id");
    }
} else {
    header("location:../index.php");
}
