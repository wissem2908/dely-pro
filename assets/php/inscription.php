<?php
session_start();
include_once 'config.php';

/* ============================================================
   1. REQUIRED FIELDS VALIDATION
============================================================ */
$required_fields = [
    'nom','prenom','date_naissance','nin','adresse',
    'tel','situation','captcha','confirm2'
];

$missing = [];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    echo json_encode([
        'response' => 'false',
        'message'  => 'empty_fields',
        'fields'   => $missing
    ]);
    exit;
}

/* ============================================================
   2. CAPTCHA VALIDATION
============================================================ */
$user_captcha    = strtoupper(trim($_POST['captcha']));
$session_captcha = $_SESSION['captcha_code'] ?? '';

if ($user_captcha !== $session_captcha) {
    echo json_encode([
        'response' => 'false',
        'message'  => 'captcha_invalid'
    ]);
    exit;
}

unset($_SESSION['captcha_code']);

/* ============================================================
   3. DATABASE CONNECTION
============================================================ */
try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    /* ========================================================
       4. COLLECT FORM DATA
    ======================================================== */
    // Site choices (arrays)
    $wilayas    = $_POST['wilaya'] ?? [];
    $projets    = $_POST['projet'] ?? [];
    $typologies = $_POST['typologie'] ?? [];

    if (count($wilayas) === 0) {
        echo json_encode([
            'response' => 'false',
            'message'  => 'no_site_selected'
        ]);
        exit;
    }

    // Personal info
    $nom        = trim($_POST['nom']);
    $prenom     = trim($_POST['prenom']);
    $date_naissance = $_POST['date_naissance'];
    $type_date_naissance = $_POST['type_date'] ?? 'N';
    $nin        = trim($_POST['nin']);
    $adresse    = trim($_POST['adresse']);
    $telephone  = trim($_POST['tel']);
    $email      = $_POST['email'] ?? null;
    $situation  = $_POST['situation'];

    // Confirmations
    $confirmation_exactitude = isset($_POST['confirm1']) ? 1 : 0;
    $confirmation_cgu        = isset($_POST['confirm2']) ? 1 : 0;

    // Metadata
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_POST['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'];

    /* ========================================================
       5. GENERATE USERNAME & PASSWORD
    ======================================================== */
    do {
        $username = 'USR-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
        $check = $bdd->prepare(
            "SELECT COUNT(*) FROM delypro_inscriptions WHERE username = ?"
        );
        $check->execute([$username]);
    } while ($check->fetchColumn() > 0);

    $plain_password = bin2hex(random_bytes(4)); // shown once

    /* ========================================================
       6. DATABASE TRANSACTION
    ======================================================== */
    $bdd->beginTransaction();

    /* ========================================================
       7. INSERT INTO delypro_inscriptions
    ======================================================== */
    $stmt = $bdd->prepare("
        INSERT INTO delypro_inscriptions (
            username, password,
            nom, prenom, date_naissance, type_date_naissance,
            nin, adresse, telephone, email, situation_matrimoniale,
            confirmation_exactitude, confirmation_cgu,
            ip_address, user_agent
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $username,
        $plain_password,
        $nom,
        $prenom,
        $date_naissance,
        $type_date_naissance,
        $nin,
        $adresse,
        $telephone,
        $email,
        $situation,
        $confirmation_exactitude,
        $confirmation_cgu,
        $ip_address,
        $user_agent
    ]);

    $id_inscription = $bdd->lastInsertId();
$reference = 'DLY-' . date('Ymd') . '-' . $bdd->lastInsertId();
    /* ========================================================
       8. INSERT MULTIPLE SITE CHOICES
    ======================================================== */
    $siteStmt = $bdd->prepare("
        INSERT INTO choix_site (wilaya, projet, typologie, id_inscription)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($wilayas as $i => $wilaya) {

        if (
            empty($wilaya) ||
            empty($projets[$i]) ||
            empty($typologies[$i])
        ) {
            continue;
        }

        $siteStmt->execute([
            $wilaya,
            $projets[$i],
            $typologies[$i],
            $id_inscription
        ]);
    }

    /* ========================================================
       9. COMMIT TRANSACTION
    ======================================================== */
    $bdd->commit();

    /* ========================================================
       10. PDF + RESPONSE
    ======================================================== */
    require_once 'generate_inscription_pdf.php';
    // require_once 'mail.php';

    echo json_encode([
        'response' => 'true',
        'message'  => 'inscription_success',
        'username' => $username,
        'password' => $plain_password,
        'pdf_url'  => $_SESSION['pdf_file'] ?? null
    ]);

} catch (Exception $e) {

    if ($bdd->inTransaction()) {
        $bdd->rollBack();
    }

    echo json_encode([
        'response' => 'false',
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);
}
