<?php
session_start();
require_once '../config.php';

header('Content-Type: application/json');

try {
    $bdd = new PDO(
        "mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // admin only
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode([]);
        exit;
    }

    $response = [];

    // TOTAL inscriptions
    $stmt = $bdd->query("SELECT COUNT(*) as total FROM delypro_inscriptions where role ='user' ");
    $response['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // en attente
    $stmt = $bdd->query("SELECT COUNT(*) as total FROM delypro_inscriptions WHERE statut='en_attente' and role ='user' ");
    $response['pending'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // en cours
    $stmt = $bdd->query("SELECT COUNT(*) as total FROM delypro_inscriptions WHERE statut='en_cours' and role ='user'");
    $response['progress'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // validés
    $stmt = $bdd->query("SELECT COUNT(*) as total FROM delypro_inscriptions WHERE statut='valide' and role ='user'");
    $response['valid'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // refusés
    $stmt = $bdd->query("SELECT COUNT(*) as total FROM delypro_inscriptions WHERE statut='refuse' and role ='user'");
    $response['refused'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // inscriptions par mois
    $stmt = $bdd->query("
        SELECT MONTH(created_at) as month, COUNT(*) as total
                    FROM delypro_inscriptions WHERE role ='user'
        GROUP BY MONTH(created_at)
        ORDER BY month
    ");

    $months = array_fill(1, 12, 0);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $months[(int)$row['month']] = (int)$row['total'];
    }

    $response['months'] = array_values($months);

    echo json_encode($response);

} catch (Exception $e) {

    echo json_encode([
        'response' => 'false',
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);
}
