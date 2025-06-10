<?php
header('Content-Type: application/json');

// Set your receiving email address
$receiving_email_address = 'musciu.studios@gmail.com';

// Basic validation
if (
    empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['subject']) ||
    empty($_POST['message']) ||
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields correctly.']);
    exit;
}

$name = strip_tags($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$subject = strip_tags($_POST['subject']);
$message = strip_tags($_POST['message']);

$email_subject = "Contact Form: $subject";
$email_body = "From: $name\n";
$email_body .= "Email: $email\n\n";
$email_body .= "Message:\n$message\n";

$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";

if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Your message has been sent. Thank you!']);
} else {
    echo json_encode(['success' => false, 'message' => 'There was an error sending your message. Please try again later.']);
}
?>
