<?php
session_start();
include_once './../config.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $userId = $_SESSION['user_id'];

    $stmt = $bdd->prepare("
        SELECT *
        FROM delypro_documents
        WHERE inscription_id = ?
    ");
    $stmt->execute([$userId]);

    $files = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $files[$row['document_type']] = $row['reference'] .'/'. $row['filename'];
    }

    echo json_encode($files);

} catch(Exception $e) {
    echo json_encode([]);
}
