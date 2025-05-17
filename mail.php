<?php
header('Content-Type: text/plain');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/mailer/PHPMailer-master/src/Exception.php';
require 'assets/mailer/PHPMailer-master/src/PHPMailer.php';
require 'assets/mailer/PHPMailer-master/src/SMTP.php';

// Input sanitization and validation
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);

// Validation
if (empty($name) || empty($email) || empty($phone) || empty($notes)) {
    die('All fields are required');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email format');
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'mail.smtp2go.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'matesnco.com';
    $mail->Password = 'Matesnco@123';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    

    // Recipients
    $mail->setFrom('info@matesnco.com', 'Matesnco Web-Enquiry');
    $mail->addReplyTo($email, $name);
    $mail->addAddress('matesncompany@gmail.com
', 'Matesnco');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission from ' . $name;
    $mail->Body = "<h3>New Contact Form Submission</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Message:</strong></p>
        <p>" . nl2br(htmlspecialchars($notes)) . "</p>";

    if ($mail->send()) {
        echo 'success';
    } else {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'Exception: ' . $e->getMessage();
}