<?php

require_once __DIR__ . '/includes/db.php';

// enable error reporting for debugging 

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($subject) || empty($message)) {

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

$safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$safeSubject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// storing contact in DB if available

$pdo = null;
try { $pdo = get_pdo_connection(); } catch (Throwable $e) {}

if ($pdo) {
    try {
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, subject, message) VALUES (?,?,?,?)');
        $stmt->execute([$name, $email, $subject, $message]);
    }
    
    catch (Throwable $e) {
        error_log('Failed to store contact: ' . $e->getMessage());
    }
}

// prepare email content (optional)
$to = 'adnan.siraz09@gmail.com';
$email_subject = "Portfolio Contact: $safeSubject";
$email_body = "New message from your portfolio website:\n\nName: $safeName\nEmail: $email\nSubject: $safeSubject\n\nMessage:\n$safeMessage\n\n---\nThis message was sent from your portfolio contact form.";


// headers as string to maximize compatibility on Windows PHP
$headers = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion() . "\r\nContent-Type: text/plain; charset=UTF-8";

// send email (may be disabled on local XAMPP)
@mail($to, $email_subject, $email_body, $headers);

echo json_encode([
    'success' => true,
    'message' => 'Thank you! Your message has been received.'
]);

?>




