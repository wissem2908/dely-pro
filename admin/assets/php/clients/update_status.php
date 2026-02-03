<?php
session_start();
include_once '../config.php';

// Only admin can change status


// Get POST values
$id     = $_POST['id'] ?? null;
$statut = $_POST['statut'] ?? null;
$motif  = $_POST['motif'] ?? null;

// Allowed statuses
$allowed = ['en_attente','en_cours','valide','refuse'];

if (!$id || !in_array($statut, $allowed)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid data'
    ]);
    exit;
}

// Motif required for refuse
if ($statut === 'refuse' && empty($motif)) {
    echo json_encode([
        'success' => false,
        'message' => 'Motif is required for refusal'
    ]);
    exit;
}

try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Update the status
    $sql = "
        UPDATE delypro_inscriptions
        SET statut = ?, 
            motif_refus = ?, 
            statut_updated_at = NOW()
        WHERE id = ?
    ";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        $statut,
        $statut === 'refuse' ? $motif : null,
        $id
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Status updated'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
