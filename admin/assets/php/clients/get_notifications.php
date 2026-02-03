<?php
session_start();
include_once '../config.php';

if (!isset($_SESSION['user_id'])) {
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

    $stmt = $bdd->prepare("
        SELECT id, inscription_id, status, message, is_read, created_at
        FROM notifications
        WHERE inscription_id = ?
        ORDER BY created_at DESC
        LIMIT 10
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($notifications);

} catch (Exception $e) {
    echo json_encode([]);
}
