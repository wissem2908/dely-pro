<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}

// Retrieve & sanitize
$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim($_POST['email'] ?? '');
$phone   = trim(strip_tags($_POST['phone'] ?? ''));
$project = trim(strip_tags($_POST['project'] ?? ''));
$subject = trim(strip_tags($_POST['subject'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

// Validation
if ($name === '' || $subject === '' || $message === '') {
    echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs obligatoires']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Email invalide']);
    exit;
}

// Email configuration
$to = 'w.omri@anurb.dz'; // CHANGE THIS
$email_subject = "Contact site web : $subject";

$email_body = "
Nom : $name
Email : $email
Téléphone : $phone
Projet : $project

Message :
$message
";

$headers  = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

// Send email
if (mail($to, $email_subject, $email_body, $headers)) {
    echo json_encode(['status' => 'success', 'message' => 'Message envoyé avec succès']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Échec de l’envoi du message']);
}
