<?php
include_once 'config.php';

try {
    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );


    include '../../admin/assets/php/clients/archive_pending_clients.php';



    $username = $_POST['username'];
    $password = $_POST['password'];

    $req = $bdd->prepare("SELECT * FROM delypro_inscriptions WHERE username=? AND password=? and is_archived = 0");
    $req->execute(array($username, $password));
    $user = $req->fetch();
    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];

        $response = [
            'status' => 'success',
            'message' => 'Connexion réussie.',
            'role'=>$user['role']
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Nom d\'utilisateur ou mot de passe incorrect.'
        ];
    }


    echo json_encode($response);
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
    exit;
}
