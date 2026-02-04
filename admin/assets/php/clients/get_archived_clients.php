<?php
session_start();
include_once '../config.php';



try {

    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $req = $bdd->prepare("
        SELECT 
        *
        FROM delypro_inscriptions where role = 'user' and is_archived = 1
        ORDER BY id DESC
    ");

    $req->execute();
    $clients = $req->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($clients);

} catch (Exception $e) {

    echo json_encode([
        'response' => false,
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);
}
