<?php
session_start();
include_once '../config.php';

$id_inscription = $_POST['id_inscription'];

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
    FROM choix_site left join wilayas on choix_site.wilaya=wilayas.id
    WHERE id_inscription  = ?
");
$req->execute(array($id_inscription));
$choix_sites = $req->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($choix_sites);


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
