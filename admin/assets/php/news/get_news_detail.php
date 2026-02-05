

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

$slug = $_GET['slug'] ?? '';

$sql = "SELECT id, title, description, image, slug,
        DATE_FORMAT(date, '%d/%m/%Y') as date_fr
        FROM news
        WHERE slug = :slug
        LIMIT 1";

$stmt = $bdd->prepare($sql);
$stmt->execute(['slug' => $slug]);

$news = $stmt->fetch(PDO::FETCH_ASSOC);

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