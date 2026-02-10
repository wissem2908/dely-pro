<?php
session_start();
header('Content-Type: application/json');

require_once '../config.php';

try {

    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // sécurité admin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode([
            'response' => false,
            'message'  => 'Accès refusé'
        ]);
        exit;
    }

    if (empty($_POST['id'])) {
        echo json_encode([
            'response' => false,
            'message'  => 'ID manquant'
        ]);
        exit;
    }

    $offerId = intval($_POST['id']);

    /* ================= récupérer fichier ================= */
    $stmt = $bdd->prepare("SELECT file_path FROM appels_offres WHERE id = ?");
    $stmt->execute([$offerId]);
    $offer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$offer) {
        echo json_encode([
            'response' => false,
            'message'  => 'Appel d\'offres introuvable'
        ]);
        exit;
    }

    /* ================= supprimer fichier ================= */
    $uploadDir = '../../uploads/appels_offres/';

    if (!empty($offer['file_path']) && file_exists($uploadDir . $offer['file_path'])) {
        unlink($uploadDir . $offer['file_path']);
    }

    /* ================= suppression DB ================= */
    $stmt = $bdd->prepare("DELETE FROM appels_offres WHERE id = ?");
    $stmt->execute([$offerId]);

    echo json_encode([
        'response' => true,
        'message'  => 'Appel d\'offres supprimé avec succès'
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'response' => false,
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);
}
