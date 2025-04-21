<?php
header('Content-Type: application/json');

// Security checks
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden - Direct access not allowed']);
    exit;
}

// Validate required fields
$required = ['name', 'email'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
        exit;
    }
}

// Validate email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address']);
    exit;
}

// Sanitize inputs
$name = htmlspecialchars(strip_tags($_POST['name']));
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$business = isset($_POST['business']) ? htmlspecialchars(strip_tags($_POST['business'])) : 'Not specified';

// Email configuration for Hostinger
$to = 'your-email@example.com'; // CHANGE THIS TO YOUR ACTUAL EMAIL
$subject = "New Contact Form Submission: $name";
$message = "You have received a new contact form submission:\n\n";
$message .= "Name: $name\n";
$message .= "Email: $email\n";
$message .= "Business Type: $business\n";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8\r\n";

// For Hostinger, it's better to use their SMTP service
ini_set('SMTP', 'localhost');
ini_set('smtp_port', 25);

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again later.']);
}
?>