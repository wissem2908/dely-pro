
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
$currentSlug = $_GET['slug'] ?? '';

$sql = "SELECT title, image, slug,
        DATE_FORMAT(date, '%d/%m/%Y') as date_fr
        FROM news
        WHERE slug != :slug
        ORDER BY date DESC
        LIMIT 5";

$stmt = $bdd->prepare($sql);
$stmt->execute(['slug' => $currentSlug]);

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