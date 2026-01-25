<?php
require_once('assets/php/config.php'); // your database connection

// Get the reference from QR code
$reference = $_GET['ref'] ?? '';

if (!$reference) {
    die("Référence invalide.");
}

try {
    $bdd = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Fetch registration info by reference
    $stmt = $bdd->prepare("SELECT * FROM delypro_inscriptions WHERE reference = ?");
    $stmt->execute([$reference]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("Aucune inscription trouvée pour cette référence.");
    }

} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Preuve d'inscription - <?php echo htmlspecialchars($reference); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f6fa; }
        .card { margin-top: 50px; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        h2 { color: #003366; }
        .info-label { font-weight: bold; color: #003366; }
        .download-btn { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h2 class="text-center">Attestation de Preuve d'Inscription</h2>
        <p class="text-center text-muted">Référence: <?php echo htmlspecialchars($data['reference']); ?></p>
        <hr>

        <p><span class="info-label">Nom & Prénom:</span> <?php echo htmlspecialchars($data['nom'] . ' ' . $data['prenom']); ?></p>
        <p><span class="info-label">Date de naissance:</span> <?php echo htmlspecialchars($data['date_naissance']); ?></p>
        <p><span class="info-label">NIN:</span> <?php echo htmlspecialchars($data['nin']); ?></p>
        <p><span class="info-label">Adresse:</span> <?php echo htmlspecialchars($data['adresse']); ?></p>
        <p><span class="info-label">Téléphone:</span> <?php echo htmlspecialchars($data['telephone']); ?></p>
        <p><span class="info-label">Situation familiale:</span> <?php echo htmlspecialchars($data['situation_matrimoniale']); ?></p>
        <p><span class="info-label">Projet:</span> <?php echo htmlspecialchars($data['projet']); ?></p>
        <p><span class="info-label">Typologie:</span> <?php echo htmlspecialchars($data['typologie']); ?></p>
        <p><span class="info-label">Date d'inscription:</span> <?php echo date('d/m/Y', strtotime($data['created_at'] ?? date('Y-m-d'))); ?></p>

        <div class="text-center download-btn">
            <?php if (!empty($data['pdf_file']) && file_exists($data['pdf_file'])): ?>
                <a href="<?php echo htmlspecialchars($data['pdf_file']); ?>" class="btn btn-primary" target="_blank">
                    Télécharger le PDF
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
