<?php
session_start();
include_once './../config.php';
header('Content-Type: application/json');

$id_client = $_POST['clientId'];



try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
$req = $bdd->prepare('UPDATE `delypro_inscriptions` SET is_archived = 0 WHERE id = ?');
$req->execute(array($id_client));


echo "true";

} catch(Exception $e) {
    echo json_encode([]);
}

?>
