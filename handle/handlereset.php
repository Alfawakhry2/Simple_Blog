<?php
require_once "../inc/conn.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once '../PhpMailer/Exception.php';
require_once '../PhpMailer/PHPMailer.php';
require_once '../PhpMailer/SMTP.php';


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


if (isset($_POST['reset']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    // fetch data
    $email = trim(htmlspecialchars($_POST['email']));

    //error arrays
    $email_err = [];

    //check if email exist
    $select_query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $select_result = mysqli_query($conn, $select_query);
    $user = mysqli_fetch_assoc($select_result);
    if (empty($email)) {
        $email_err[] = $msg['Email required'];
    } elseif (mysqli_num_rows($select_result) == 0) {
        $email_err[] = $msg['account not correct'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err[] = $msg['Incorrect email'];
    }



    if (empty($email_err)) {
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $update = $conn->prepare("UPDATE `users` SET `code` = ? WHERE email = ?");
        $update->bind_param("ss", $code, $email);
        $update->execute();

        /**********************************send code message *****************/

        $phpmailer  = new PHPMailer(true);

        try {
            //Server settings
            // $phpmailer->SMTPDebug = SMTP::DEBUG_SERVER;  //Enable verbose debug output
            $phpmailer->SMTPDebug = SMTP::DEBUG_OFF;  //Enable verbose debug output

            // Looking to send emails in production? Check out our Email API/SMTP product!
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 587;
            $phpmailer->Username = 'b865876b807ac9';
            $phpmailer->Password = '8ae6c5bb96b40b';                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $phpmailer->setFrom('Blog@blog.com', 'Blog Mail');
            $phpmailer->addAddress("$email", $user['name']);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $phpmailer->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $phpmailer->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $phpmailer->isHTML(true);                                  //Set email format to HTML
            $phpmailer->Subject = 'Password Reset';
            $phpmailer->Body    = 'Hello </b>' . $user['name'] . "This is code $code";
            $phpmailer->AltBody = 'Hello </b>' . $user['name'] . "This is code $code";

            if ($phpmailer->send()) {
                $_SESSION['sent'] = 'Code has been sent';
            }
        } catch (Exception $e) {
            $_SESSION['failed']  = "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }

        /***************************************end send code message*****************************************/

        if (isset($_SESSION['failed'])) {
            header("location:../forgetpassword.php");
        }
        $_SESSION['success'] = [$msg["check Your Email Inbox"]];
        $_SESSION['email'] = $email ; 
        header("location:../otp.php");
    } else {
        $_SESSION['email_err'] = $email_err;
        header("location:../forgetpassword.php");
    }
} else {
    header("location:../login.php");
}
