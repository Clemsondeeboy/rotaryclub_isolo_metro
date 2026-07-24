<?php
require_once "config/db.php";

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $subject  = trim($_POST['subject'] ?? '');
    $message  = trim($_POST['message'] ?? '');

    if (empty($fullname) || empty($email) || empty($phone) || empty($message)) {
        header("Location: contact.php?error=empty_fields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=invalid_email");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (fullname, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssss", $fullname, $email, $phone, $subject, $message);
        $stmt->execute();
        $stmt->close();
    }

    $file_body = "Below is the info that was filled:\n"
        . "Name: " . $fullname . "\n"
        . "Email: " . $email . "\n"
        . "Phone: " . $phone . "\n"
        . "Subject: " . $subject . "\n"
        . "Message: " . $message . "\n"
        . "***************************\n\n";

    file_put_contents('data.txt', $file_body, FILE_APPEND | LOCK_EX);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@rotaryisolometro.org';
        $mail->Password   = 'YOUR_16_CHAR_APP_PASSWORD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('info@rotaryisolometro.org', 'Rotary Club Isolo Metro');
        $mail->addAddress('info@rotaryisolometro.org');
        $mail->addReplyTo($email, $fullname);

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Message: ' . ($subject ?: 'Website Feedback');
        $mail->Body    = "<p><strong>Name:</strong> {$fullname}</p><p><strong>Email:</strong> {$email}</p><p><strong>Message:</strong><br>{$message}</p>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }



    header("Location: contact.php?status=success");
    exit();
}
