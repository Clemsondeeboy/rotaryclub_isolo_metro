<?php
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $subject  = trim($_POST['subject']);
    $message  = trim($_POST['message']);

    if (empty($fullname) || empty($email) || empty($message)) {
        header("Location: contact.php?error=1");
        exit();
    }

    $fullname = mysqli_real_escape_string($conn, $fullname);
    $email    = mysqli_real_escape_string($conn, $email);
    $phone    = mysqli_real_escape_string($conn, $phone);
    $subject  = mysqli_real_escape_string($conn, $subject);
    $message  = mysqli_real_escape_string($conn, $message);

    $sql = "INSERT INTO contact_messages
            (fullname,email,phone,subject,message)
            VALUES
            ('$fullname','$email','$phone','$subject','$message')";

    if(mysqli_query($conn,$sql)){

        header("Location: contact.php?success=1");
        exit();

    }else{

        header("Location: contact.php?error=1");
        exit();

    }

}else{

    header("Location: contact.php");
    exit();

}
?>