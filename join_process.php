<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname     = trim($_POST['fullname']);
    $email        = trim($_POST['email']);
    $phone        = trim($_POST['phone']);
    $gender       = trim($_POST['gender']);
    $dob          = trim($_POST['dob']);
    $occupation   = trim($_POST['occupation']);
    $organization = trim($_POST['organization']);
    $address      = trim($_POST['address']);
    $reason       = trim($_POST['reason']);

    if (
        empty($fullname) ||
        empty($email) ||
        empty($phone) ||
        empty($gender) ||
        empty($reason)
    ) {
        header("Location: join.php?error=1");
        exit();
    }

    $message = "

=============================
NEW MEMBERSHIP APPLICATION
=============================

Full Name: $fullname
Email: $email
Phone: $phone
Gender: $gender
Date of Birth: $dob
Occupation: $occupation
Organization: $organization
Address: $address

Reason For Joining:
$reason

Submitted On: " . date("d M Y h:i A") . "

----------------------------------------

";


    if ($_SERVER['SERVER_NAME'] == "localhost") {

        file_put_contents("data.txt", $message, FILE_APPEND | LOCK_EX);

        header("Location: join.php?success=1");
        exit();
    }


    else {

        // PHPMailer code goes here later

        header("Location: join.php?success=1");
        exit();
    }

} else {

    header("Location: join.php");
    exit();

}