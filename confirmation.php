<?php
session_start();
include 'includes/header.php';

if (!isset($_SESSION['pdf_file'])) {
    header('Location: index.php');
    exit;
}

$pdfFile = $_SESSION['pdf_file'];
?>

<div class="container my-5" style="max-width: 700px; height:100vh">
    <div class="card shadow border-0">
        <div class="card-body text-center p-5">

        <div class="mb-4">
<i class="bi bi-check-circle-fill text-success"
   style="font-size:70px;"></i>
</div>


            <h3 class="fw-bold mb-3">Votre demande a été enregistrée</h3>
<p class="text-muted mb-4">
    Les informations transmises ont été enregistrées avec succès.<br>
    Vous pouvez maintenant télécharger le document de preuve d’inscription au format PDF.
</p>

            <a href="<?php echo htmlspecialchars('assets/'.$pdfFile); ?>" 
               class="btn btn-primary btn-lg px-5 py-3"
               download>
                Télécharger le PDF
            </a>

            <div class="mt-4">
                <a href="index.php" class="text-decoration-none text-muted">
                    Retour à l’accueil
                </a>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
