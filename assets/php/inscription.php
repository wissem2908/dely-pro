<?php
session_start(); // needed for captcha

include_once 'config.php';

// ===== 1. Validate required fields =====
$required_fields = ['nom','prenom','date_naissance','nin','adresse','tel','situation','captcha'];
$missing = [];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    echo json_encode(['response'=>'false','message'=>'empty_fields','fields'=>$missing]);
    exit;
}

// ===== 2. Validate captcha =====
// $user_captcha = strtoupper(trim($_POST['captcha']));
// $session_captcha = $_SESSION['captcha_code'] ?? '';
// if ($user_captcha !== $session_captcha) {
//     echo json_encode(['response'=>'false','message'=>'captcha_invalid']);
//     exit;
// }
// unset($_SESSION['captcha_code']); // prevent reuse

try {
    // ===== 3. Connect to DB =====
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // ===== 4. Collect form data =====
    $wilaya = $_POST['wilaya'] ?? null;
    $projet = $_POST['projet'] ?? null;
    $typologie = $_POST['typologie'] ?? null;

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $type_date_naissance = $_POST['type_date'] ?? 'N';
    $nin = $_POST['nin'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['tel'];
    $email = $_POST['email'] ?? null;
    $situation_matrimoniale = $_POST['situation'];

    // Confirmations
    $confirmation_exactitude = isset($_POST['confirm1']) ? 1 : 0;
    $confirmation_cgu = isset($_POST['confirm2']) ? 1 : 0;

    // Metadata
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_POST['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? null;

    // ===== 5. Insert into database =====
    $stmt = $bdd->prepare("
        INSERT INTO delypro_inscriptions (
            wilaya, projet, typologie, nom, prenom, date_naissance, type_date_naissance,
            nin, adresse, telephone, email, situation_matrimoniale,
            confirmation_exactitude, confirmation_cgu, ip_address, user_agent
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $res = $stmt->execute([
        $wilaya, $projet, $typologie, $nom, $prenom, $date_naissance, $type_date_naissance,
        $nin, $adresse, $telephone, $email, $situation_matrimoniale,
        $confirmation_exactitude, $confirmation_cgu, $ip_address, $user_agent
    ]);

    if ($res) {
        

    // ===== 6. Generate PDF proof using TCPDF =====
    require_once  'generate_inscription_pdf.php';
        echo json_encode(['response'=>'true','message'=>'inscription_success']);
    } else {
        echo json_encode(['response'=>'false','message'=>'error_inserting']);
    }

} catch (Exception $e) {
    echo json_encode([
        'response'=>'false',
        'message'=>'exception',
        'error'=>$e->getMessage()
    ]);
}
