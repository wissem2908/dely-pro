<?php
require_once('./TCPDF-main/tcpdf.php');

class DELYPRO_PDF extends TCPDF
{

    // Header
    public function Header()
    {

        // Left logo
        $leftLogo =  '../images/delypro-logo.jpg';
        if (file_exists($leftLogo)) {
            $this->Image($leftLogo, 15, 15, 45);
        }

        // Right logo
        $rightLogo =  '../images/cneru_logo.png';
        if (file_exists($rightLogo)) {
            $this->Image(
                $rightLogo,
                $this->getPageWidth() - 20 - 25, // right aligned (margin + width)
                10,
                25
            );
        }
        // Arabic text (needs Unicode font)
        $this->SetFont('dejavusans', '', 9);
        $this->SetTextColor(0, 0, 0);

        $arabicHtml = '
        <div style="text-align:center; line-height:1.3;">
            <b>الجمهورية الجزائرية الديموقراطية الشعبية</b><br>
            وزارة السكن والعمران والمدينة والتهيئة العمرانية<br>
            الوكالة الوطنية للتعمير<br>
            المركز الوطني للدراسات والأبحاث التطبيقية في العمران<br>
            <b>مؤسسة الترقية العقارية دليبرو</b>
        </div>';

        $this->writeHTMLCell(0, 0, 0, 12, $arabicHtml, 0, 1, false, true, 'C', true);

        // French text (Times New Roman style)
        $this->SetFont('times', 'B', 10);

        $frenchHtml = '
        <div style="text-align:center; margin-top:6px;">
            Société de Promotion Immobilière DELYPRO
        </div>';

        $this->writeHTMLCell(0, 0, 0, '', $frenchHtml, 0, 1, false, true, 'C', true);

        // Separator line
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.6);
        $this->Line(15, 40, $this->getPageWidth() - 15, 40);
    }

    // Footer
    public function Footer()
    {

        $this->SetY(-30);
        $this->SetFont('times', '', 8);
        $this->SetTextColor(90, 90, 90);

        $footerHtml = '
        <div style="text-align:center; line-height:1.4;">
         SOCIÉTÉ EPE DELYPRO SPA filiale du groupe CNERU au capital de 762 000 000.00 D   <br> 
Raison sociale : | RC : 04B965652 | NIF : 00041609656523500000<br>
Adresse :  Lotissement Mohamed Saidoune Bt : B n°14, ben Omar, Kouba<br>
Tél / fax : +213 (0)28.46.66.83| E-mail : delypro@gmail.com <br>

        </div>';

        $this->writeHTMLCell(0, 0, '', '', $footerHtml, 0, 1, false, true, 'C', true);

        // Page number
        $this->Ln(2);
        $this->Cell(
            0,
            5,
            'Page ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(),
            0,
            0,
            'C'
        );
    }
}




// Create new PDF
// $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
// $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf = new DELYPRO_PDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Document info
$pdf->SetCreator('DELYPRO');
$pdf->SetAuthor('DELYPRO');
$pdf->SetTitle('Preuve d\'inscription');
$pdf->SetSubject('Attestation');

// Page setup
$pdf->SetMargins(20, 50, 20);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(25);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();

// // --- Logo ---
// $logoPath = '../images/delypro-logo.jpg';
// if(file_exists($logoPath)){
//     $pdf->Image($logoPath, 70, 15, 70); // Centered horizontally, Width=50
// }

// --- Header Title ---
$pdf->SetFont('dejavusans', 'B', 16);
$pdf->SetTextColor(0, 51, 102); // dark blue
// $pdf->Ln(20); // spacing from logo
$pdf->Cell(0, 20, 'FICHE D\'INSCRIPTION', 0, 1, 'C');

// Decorative line
// $pdf->SetLineWidth(1);
// $pdf->SetDrawColor(0, 51, 102);
// $pdf->Line(30, $pdf->GetY(), $pdf->getPageWidth()-30, $pdf->GetY());
$pdf->Ln(10);

// --- Body ---
// $pdf->SetFont('helvetica', '', 14); // clean, professional, bigger text


/* ============================================================
   FETCH SITE CHOICES (1 → MANY)
============================================================ */
$stmt = $bdd->prepare("
    SELECT wilaya, projet, typologie
    FROM choix_site
    WHERE id_inscription  = ?
");
$stmt->execute([$id_inscription]);
$sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ============================================================
   BUILD HTML TABLE FOR SITES
============================================================ */
$sitesHtml = '
<table border="1" cellpadding="6">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th width="20%"><b>Wilaya</b></th>
            <th width="50%"><b>Projet</b></th>
            <th width="30%"><b>Typologie</b></th>
        </tr>
    </thead>
    <tbody>
';

foreach ($sites as $site) {
    $sitesHtml .= '
        <tr>
            <td width="20%">' . htmlspecialchars($site['wilaya']) . '</td>
            <td width="50%">' . htmlspecialchars($site['projet']) . '</td>
            <td width="30%">' . htmlspecialchars($site['typologie']) . '</td>
        </tr>
    ';
}

$sitesHtml .= '</tbody></table><br>';



$pdf->SetFont('dejavusans', '', 14);
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
<b>Situation familiale</b>: $situation<br>

<b>Date d'inscription</b>: " . date('d/m/Y') . "<br><br>

<b>Choix du site :</b><br><br>
$sitesHtml

</div>
";

// Use writeHTMLCell to parse HTML with spacing
$pdf->writeHTMLCell(
    0,     // width (0 = full page width minus margins)
    0,     // height (0 = auto)
    10,    // X position (empty = current)
    '',    // Y position (empty = current)
    $body, // HTML content
    0,     // border
    2,     // line after
    false, // fill
    true,  // reset height
    '',    // align
    true   // autopadding
);


$pdf->Ln(5);

// Labels
$pdf->setRTL(false);
$pdf->SetFont('dejavusans', '', 11);
$pdf->Cell(40, 8, 'Code Utilisateur :', 0, 0);

// Username box
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 55, 8);
$pdf->Cell(50, 8, $username, 0, 0, 'C');

$pdf->Cell(10, 8, '', 0, 0);

// Password label
$pdf->Cell(30, 8, 'Mot de passe :', 0, 0);

// Password box
$pdf->Rect($pdf->GetX(), $pdf->GetY(), 45, 8);
$pdf->Cell(45, 8, $plain_password, 0, 1, 'C');

//$pdf->Ln(6);


// $pdf->setRTL(true);
// $pdf->SetFont('dejavusans', '', 11);

// $arText = "
// سيدي، آنستي، سيدي:
// - يرجى منكم الاحتفاظ بهذه الوثيقة بعناية وكذلك رقم التسجيل وكلمة المرور للتمكن من الدخول إلى التطبيق باستخدام هذين الرمزين لاحقًا.
// - الرجاء إيداع الملف كاملًا مرفقًا بوثيقة التسجيل على مستوى المصالح التجارية لمديرية المشاريع المعنية بولايتكم.
// - في حالة عدم إيداع ملفكم الإداري لدراسته خلال 15 يومًا من تاريخ التسجيل، يُلغى تسجيلكم تلقائيًا.

// ملاحظة : من اجل مزيد من المعلومات الرجاء تفحص الموقع التالي dz.delypro.www.
// ";

// $pdf->MultiCell(0, 6, $arText, 0, 'R');
$pdf->Ln(6);
$pdf->SetFont('dejavusans', '', 10);
$pdf->SetTextColor(0, 0, 0);

$test = "
<div style='line-height:1.6;'> <!-- 1.6 = 60% extra spacing -->
Madame, Mademoiselle, Monsieur ;
<br>
- Vous êtes invité(e) à garder soigneusement la fiche d'inscription, le code d'utilisateur et
le mot de passe afin d'accéder à votre compte plus tard.
<br>
- Veuillez déposer le dossier complet avec la fiche d'inscription au niveau de la direction des
projet de votre Wilaya.<br>
- Votre dossier complet doit nous parvenir dans 15 jours suivant la date d'inscription,
dépassé ce délai votre demande sera annulée.

</div>
";

// Use writeHTMLCell to parse HTML with spacing
$pdf->writeHTMLCell(
    0,     // width (0 = full page width minus margins)
    0,     // height (0 = auto)
    10,    // X position (empty = current)
    '',    // Y position (empty = current)
    $test, // HTML content
    0,     // border
    2,     // line after
    false, // fill
    true,  // reset height
    'L',    // align
    true   // autopadding
);

$pdf->Ln(6);
$pdf->SetFont('dejavusans', '', 12);
$pdf->SetTextColor(0, 0, 0);

$test2 = "
<div style='line-height:1.6;'> <!-- 1.6 = 60% extra spacing -->
La présente inscription ne vaut ni réservation ni engagement et ne confère aucun droit à l'acquisition, avant le traitement de l'ensemeble des demandes.  

</div>
";

// Use writeHTMLCell to parse HTML with spacing
$pdf->writeHTMLCell(
    0,     // width (0 = full page width minus margins)
    0,     // height (0 = auto)
    10,    // X position (empty = current)
    '',    // Y position (empty = current)
    $test2, // HTML content
    0,     // border
    2,     // line after
    false, // fill
    true,  // reset height
    'L',    // align
    true   // autopadding
);

// --- QR Code ---
$qrStyle = ['border' => 0, 'padding' => 2, 'fgcolor' => [0, 0, 0], 'bgcolor' => false];
$qrUrl = "http://delypro.dz/inscription_details.php?ref=$reference";
$pdf->write2DBarcode($qrUrl, 'QRCODE,H', 160, "", 45, 45, $qrStyle, 'N');

// --- Footer ---
$pdf->SetFont('dejavusans', 'I', 14);
$pdf->SetTextColor(100, 100, 100);
// $pdf->MultiCell(0, 7, "Ce document est généré électroniquement et fait foi.", 0, 'C', false, 1, '', '', true);

// Save PDF
$pdfDir = __DIR__ . "/../uploads/inscription_pdf/";
if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

$pdfFile = $pdfDir . "$reference.pdf";
$pdf->Output($pdfFile, 'F');

// Store URL for frontend
$_SESSION['pdf_file'] = "uploads/inscription_pdf/$reference.pdf";
// $lastInsertId = $bdd->lastInsertId();

$stmt = $bdd->prepare("
    UPDATE delypro_inscriptions 
    SET reference = ?, pdf_file = ? 
    WHERE id = ?
");
$stmt->execute([$reference, $reference . ".pdf", $id_inscription]);
// JSON response
