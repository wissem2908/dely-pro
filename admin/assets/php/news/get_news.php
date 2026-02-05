<?php
session_start();
require_once '../config.php'; // adapte si besoin
try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

// Sécurité : admin uniquement
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode([]);
    exit;
}

$sql = "SELECT 
            id,
            title,
            description,
            image,
            slug,
            DATE_FORMAT(date, '%d/%m/%Y') AS date_fr
        FROM news
        ORDER BY date DESC";

$stmt = $bdd->prepare($sql);
$stmt->execute();

$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($news);

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