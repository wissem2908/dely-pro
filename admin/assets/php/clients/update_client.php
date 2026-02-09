<?php
session_start();
include_once '../config.php';

/* ============================================================
   1. REQUIRED FIELDS VALIDATION
============================================================ */
$required_fields = [
    'client_id','nom','prenom','date_naissance','nin',
    'adresse','tel','situation'
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
    $id_inscription = intval($_POST['client_id']);

    // Site choices
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




    /* ========================================================
       5. TRANSACTION
    ======================================================== */
    $bdd->beginTransaction();

    /* ========================================================
       6. UPDATE delypro_inscriptions
    ======================================================== */
    $stmt = $bdd->prepare("
        UPDATE delypro_inscriptions SET
            nom = ?,
            prenom = ?,
            date_naissance = ?,
            type_date_naissance = ?,
            nin = ?,
            adresse = ?,
            telephone = ?,
            email = ?,
            situation_matrimoniale = ?
        
        WHERE id = ?
    ");

    $stmt->execute([
        $nom,
        $prenom,
        $date_naissance,
        $type_date_naissance,
        $nin,
        $adresse,
        $telephone,
        $email,
        $situation,
     
        $id_inscription
    ]);

    /* ========================================================
       7. DELETE OLD SITE CHOICES
    ======================================================== */
    $bdd->prepare("DELETE FROM choix_site WHERE id_inscription = ?")
        ->execute([$id_inscription]);

    /* ========================================================
       8. INSERT UPDATED SITE CHOICES
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
       9. COMMIT
    ======================================================== */
    $bdd->commit();

    /* ========================================================
       10. RESPONSE
    ======================================================== */
    echo json_encode([
        'response' => 'true',
        'message'  => 'update_success'
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
