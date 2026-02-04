<?php
include_once './config.php';



try {

    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

 $sql = "
    UPDATE delypro_inscriptions
    SET is_archived = 1
    WHERE statut = 'en_attente'
      AND created_at <= DATE_SUB(NOW(), INTERVAL 15 DAY)
";

$stmt = $bdd->prepare($sql);
$stmt->execute();

} catch (Exception $e) {

    echo json_encode([
        'response' => false,
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);

}
