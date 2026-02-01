<?php
session_start();
include_once './../config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Non autorisé'
    ]);
    exit;
}

try {
    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $userId = $_SESSION['user_id'];
    $uploadDir = "../../../../assets/uploads/files_uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
    $uploadedFiles = [];

    $fields = ['piece_identite', 'extrait_naissance'];

    foreach ($fields as $field) {

        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== 0) {
            continue;
        }

        $extension = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExt)) {
            echo json_encode([
                'status' => 'error',
                'message' => "Format non autorisé : $field"
            ]);
            exit;
        }

        $filename = $field . "_" . $userId . "_" . time() . "." . $extension;
        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $destination)) {
            echo json_encode([
                'status' => 'error',
                'message' => "Échec upload : $field"
            ]);
            exit;
        }

        $uploadedFiles[] = $filename;
    }

    if (empty($uploadedFiles)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Aucun fichier reçu'
        ]);
        exit;
    }

    // Save filenames (comma separated)
    $filesString = implode(',', $uploadedFiles);

    $update = $bdd->prepare("
        UPDATE delypro_inscriptions
        SET pdf_file = ?, statut = 'en_cours'
        WHERE id = ?
    ");
    $update->execute([$filesString, $userId]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Fichiers téléchargés avec succès'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
