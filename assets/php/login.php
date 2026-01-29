<?php
include_once 'config.php';

try {
    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );



    $username=$_POST['username'];
    $password=$_POST['password'];

    $req = $bdd->prepare("SELECT * FROM delypro_inscriptions WHERE username=? AND password=?");
    $req->execute(array($username, $password));
    $user = $req->fetch();
    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        $response = [
            'status' => 'success',
            'message' => 'Connexion réussie.'
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
?>
