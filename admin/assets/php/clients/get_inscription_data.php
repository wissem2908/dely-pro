<?php
session_start();
include_once '../config.php';

$user_id = null;
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $user_id = $_POST['id'];
} else {
    $user_id = $_SESSION['user_id'];
}


// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

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
    FROM delypro_inscriptions
    WHERE id = ?
");
    $req->execute([$user_id]);
    $user = $req->fetch(PDO::FETCH_ASSOC);
    echo json_encode($user);
    if (!$user) {
        die("Utilisateur introuvable");
    }
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
