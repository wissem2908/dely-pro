<?php
require_once('./TCPDF-main/tcpdf.php');


$reference = 'DLY-' . date('Ymd') . '-' . $bdd->lastInsertId();

// Create new PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Document info
$pdf->SetCreator('DELYPRO');
$pdf->SetAuthor('DELYPRO');
$pdf->SetTitle('Preuve d\'inscription');
$pdf->SetSubject('Attestation');

// Page setup
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

// --- Logo ---
$logoPath = '../images/delypro-logo.jpg';
if(file_exists($logoPath)){
    $pdf->Image($logoPath, 70, 15, 70); // Centered horizontally, Width=50
}

// --- Header Title ---
$pdf->SetFont('dejavusans', 'B', 16);
$pdf->SetTextColor(0, 51, 102); // dark blue
$pdf->Ln(20); // spacing from logo
$pdf->Cell(0, 20, 'ATTESTATION DE PREUVE D\'INSCRIPTION', 0, 1, 'C');

// Decorative line
$pdf->SetLineWidth(1);
$pdf->SetDrawColor(0, 51, 102);
$pdf->Line(30, $pdf->GetY(), $pdf->getPageWidth()-30, $pdf->GetY());
$pdf->Ln(15);

// --- Body ---
$pdf->SetFont('helvetica', '', 14); // clean, professional, bigger text
$pdf->SetTextColor(0, 0, 0);

$body = "
<div style='line-height:1.6;'> <!-- 1.6 = 60% extra spacing -->
Par la présente, nous attestons que la demande suivante a été enregistrée avec succès dans notre système:<br><br>

<b>Référence</b>: $reference<br>
<b>Nom et Prénom</b>: $nom $prenom<br>
<b>Date de naissance</b>: $date_naissance ($type_date_naissance)<br>
<b>NIN</b>: $nin<br>
<b>Adresse</b>: $adresse<br>
<b>Téléphone</b>: $telephone<br>
<b>Situation familiale</b>: $situation_matrimoniale<br>
<b>Projet</b>: $projet<br>
<b>Typologie</b>: $typologie<br>
<b>Date d'inscription</b>: ".date('d/m/Y')."<br><br>


</div>
";

// Use writeHTMLCell to parse HTML with spacing
$pdf->writeHTMLCell(
    0,     // width (0 = full page width minus margins)
    0,     // height (0 = auto)
    '',    // X position (empty = current)
    '',    // Y position (empty = current)
    $body, // HTML content
    0,     // border
    1,     // line after
    false, // fill
    true,  // reset height
    '',    // align
    true   // autopadding
);


// --- QR Code ---
$qrStyle = ['border'=>0,'padding'=>2,'fgcolor'=>[0,0,0],'bgcolor'=>false];
$qrUrl = "https://dely-pro.dz/inscription_details.php?ref=$reference";
$pdf->write2DBarcode($qrUrl, 'QRCODE,H', 160, 200, 45, 45, $qrStyle, 'N');

// --- Footer ---
$pdf->SetFont('dejavusans', 'I', 14);
$pdf->SetTextColor(100, 100, 100);
// $pdf->MultiCell(0, 7, "Ce document est généré électroniquement et fait foi.", 0, 'C', false, 1, '', '', true);

// Save PDF
$pdfDir = __DIR__ . "/../uploads/inscription_pdf/";
if(!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

$pdfFile = $pdfDir . "$reference.pdf";
$pdf->Output($pdfFile, 'F');

// Store URL for frontend
$_SESSION['pdf_file'] = "uploads/inscription_pdf/$reference.pdf";
 $lastInsertId=$bdd->lastInsertId();

$stmt = $bdd->prepare("
    UPDATE delypro_inscriptions 
    SET reference = ?, pdf_file = ? 
    WHERE id = ?
");
$stmt->execute([$reference, $reference.".pdf", $lastInsertId]);
// JSON response

?>
