<?php
include_once 'config.php';

try {
    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $bdd->query("SELECT * FROM `appels_offres` ORDER BY `id` DESC");
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($news);

} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
    exit;
}
?>
