<?php
session_start();
include_once '../config.php';

$clientId = $_POST['clientId'];

try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

$req = $bdd->prepare("
    SELECT 
  *
    FROM choix_site 
    WHERE id_inscription  = ?
");
$req->execute(array($clientId));
$info = $req->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($info);


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

?>
