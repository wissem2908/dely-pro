<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require  './PHPMailer-master/src/PHPMailer.php';
require  './PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json');

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Méthode non autorisée']);
    exit;
}

// Sanitize inputs
$name = trim(strip_tags($_POST['name'] ?? ''));
$email = trim($_POST['email'] ?? '');
$phone = trim(strip_tags($_POST['phone'] ?? ''));
$project = trim(strip_tags($_POST['project'] ?? ''));
$subject = trim(strip_tags($_POST['subject'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

// Validation
if($name==='' || $email==='' || $subject==='' || $message===''){
    echo json_encode(['status'=>'error','message'=>'Veuillez remplir tous les champs obligatoires']);
    exit;
}
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo json_encode(['status'=>'error','message'=>'Email invalide']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';  // or your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'omri.wissem.23@gmail.com';       // CHANGE
    $mail->Password   = '#';         // CHANGE
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('omri.wissem.23@gmail.com', 'DelyPro Website'); // your email
    $mail->addReplyTo($email, $name);
    $mail->addAddress('w.omri@anurb.dz'); // receiver

    // Content
    $mail->isHTML(false);
    $mail->Subject = "Contact site : $subject";
    $mail->Body = "Nom: $name\nEmail: $email\nTéléphone: $phone\nProjet: $project\n\nMessage:\n$message";

    $mail->send();

    echo json_encode(['status'=>'success','message'=>'Message envoyé avec succès']);
} catch (Exception $e) {
    echo json_encode(['status'=>'error','message'=>'Erreur SMTP: '.$mail->ErrorInfo]);
}
