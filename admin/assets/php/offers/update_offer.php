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

    // Sécurité admin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode([
            'response' => false,
            'message'  => 'Accès refusé'
        ]);
        exit;
    }

    // Vérification champs obligatoires
    if (empty($_POST['offer_id']) || empty($_POST['title']) || empty($_POST['description'])) {
        echo json_encode([
            'response' => false,
            'message'  => 'Champs obligatoires manquants'
        ]);
        exit;
    }

    $offerId     = intval($_POST['offer_id']);
    $title       = trim($_POST['title']);
    $description = $_POST['description'];

    /* ====================== récupérer ancien fichier ====================== */
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

    $currentFile = $offer['file_path'];
    $newFileName = $currentFile;

    /* ====================== upload nouveau document (optionnel) ====================== */
    if (!empty($_FILES['document']['name'])) {

        $uploadDir = '../../uploads/appels_offres/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmp  = $_FILES['document']['tmp_name'];
        $fileExt  = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));

        $allowedExt = ['jpg','jpeg','png','webp','pdf','doc','docx'];

        if (!in_array($fileExt, $allowedExt)) {
            echo json_encode([
                'response' => false,
                'message'  => 'Format document non autorisé'
            ]);
            exit;
        }

        // nouveau nom
        $newFileName = uniqid('offers_', true) . '.' . $fileExt;
        $destination = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTmp, $destination)) {
            echo json_encode([
                'response' => false,
                'message'  => 'Erreur upload document'
            ]);
            exit;
        }

        // supprimer ancien fichier
        if (!empty($currentFile) && file_exists($uploadDir . $currentFile)) {
            unlink($uploadDir . $currentFile);
        }
    }

    /* ====================== update base ====================== */
    $sql = "UPDATE appels_offres 
            SET title = :title,
                description = :description,
                file_path = :file
            WHERE id = :id";

    $stmt = $bdd->prepare($sql);

    $stmt->execute([
        ':title'       => $title,
        ':description' => $description,
        ':file'        => $newFileName,
        ':id'          => $offerId
    ]);

    echo json_encode([
        'response'  => true,
        'message'   => 'Appel d\'offres modifié avec succès',
        'file_path' => $newFileName
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'response' => false,
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);
}
