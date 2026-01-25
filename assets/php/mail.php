<?php
// ===== 7. Send email with PDF attachment =====

$to = $email; // recipient email
$subject = "Votre attestation de preuve d'inscription";
$message = "
<html>
<head>
  <title>Attestation de Preuve d'Inscription</title>
</head>
<body>
  <p>Bonjour <b>$nom $prenom</b>,</p>
  <p>Votre attestation de preuve d'inscription a été générée avec succès.</p>
  <p>Référence: <b>$reference</b></p>
  <p>Merci pour votre inscription.</p>
  <br>
  <p>Cordialement,<br>DELYPRO</p>
</body>
</html>
";

// Read PDF file content
$file = $pdfFile;
$file_size = filesize($file);
$handle = fopen($file, "r");
$content = fread($handle, $file_size);
fclose($handle);
$encoded_content = chunk_split(base64_encode($content));

// Unique boundary
$boundary = md5("DELYPRO-PDF-" . time());

// Headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "From: DEYPRO <no-reply@yourdomain.com>\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

// Email body
$body = "--$boundary\r\n";
$body .= "Content-Type: text/html; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message . "\r\n";

// Attachment
$body .= "--$boundary\r\n";
$body .= "Content-Type: application/pdf; name=\"" . basename($file) . "\"\r\n";
$body .= "Content-Disposition: attachment; filename=\"" . basename($file) . "\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= $encoded_content . "\r\n";
$body .= "--$boundary--";

// Send email
if(mail($to, $subject, $body, $headers)){
    echo json_encode(['response'=>'true','message'=>'Inscription et email envoyés avec succès.']);
}else{
    echo json_encode(['response'=>'false','message'=>'Impossible d’envoyer l’email.']);
}
