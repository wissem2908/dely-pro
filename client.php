<?php include 'includes/header.php'; ?>

<div class="container my-5" style="max-width: 1100px;">

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h5 class="text-danger fw-bold">Remplissez le formulaire</h5>
      
        <p class="text-muted mb-0">Veuillez renseigner les informations demandées avec exactitude</p>
    </div>

    <form method="post" action="traitement.php">

        <!-- Choix du site -->
        <div class="card border-1 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Choix du site</h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Wilayas</label>
                        <select class="form-select" name="wilaya">
                            <option value="">Choisir...</option>
                            <option value="Alger">Alger</option>
                            <option value="Oran">Oran</option>
                            <option value="Blida">Blida</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Projet</label>
                        <input type="text" class="form-control" name="projet">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Typologie</label>
                        <input type="text" class="form-control" name="typologie">
                    </div>
                </div>
            </div>
        </div>

        <!-- Souscripteur -->
        <div class="card border-1 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Informations concernant le souscripteur</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nom" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="prenom" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="date_naissance" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Type Date de naissance
                            <small class="text-muted">(P: présumée, N: non)</small>
                        </label>
                        <input type="text" class="form-control" name="type_date" value="N">
                    </div>

                    <div class="col-12">
                        <label class="form-label">NIN (Numéro d'Identification National) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nin" inputmode="numeric" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Adresse actuelle <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="adresse" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tél (Whatsapp / Viber / Telegram) <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="tel" placeholder="+213" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Situation matrimoniale</label>
                        <select class="form-select" name="situation">
                            <option value="Célibataire">Célibataire</option>
                            <option value="Marié(e)" selected>Marié(e)</option>
                            <option value="Divorcé(e)">Divorcé(e)</option>
                            <option value="Veuf(ve)">Veuf(ve)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sécurité & validation -->
        <div class="card border-1 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Vérification et confirmation</h5>

                <!-- Captcha -->
         <!-- Captcha -->
<div class="row align-items-center g-3 mb-4">
    <div class="col-md-4">
        <img src="assets/php/captcha.php" alt="Code de vérification" class="img-fluid border rounded">
    </div>
    <div class="col-md-4">
        <label class="form-label">Code de vérification</label>
        <input type="text" class="form-control" name="captcha" required>
    </div>
</div>


                <!-- Confirmations -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirm1" required>
                    <label class="form-check-label fw-bold text-danger" for="confirm1">
                        Je confirme que toutes les informations sont justes.
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirm2" required>
                    <label class="form-check-label" for="confirm2">
                        En soumettant ce formulaire, j'accepte les
                        <b>conditions générales d'utilisation</b> et autorise
                        <b>DELYPRO</b> à utiliser mes informations pour me recontacter.
                        <span class="text-danger">*</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg py-3 shadow">
                Valider les informations
            </button>
        </div>

    </form>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault(); // prevent default form submission

        // Collect form data
        var formData = $(this).serializeArray(); // get all form inputs
        var data = {};

        // Convert form data to an object
        $.each(formData, function(_, field) {
            data[field.name] = field.value;
        });

        // Add user agent and IP
        data.user_agent = navigator.userAgent;

        $.ajax({
            url: 'assets/php/inscription.php', 
            type: 'POST',
            data: data,
            success: function(response) {
                // Handle success
                alert('Formulaire soumis avec succès !');
                console.log(response); // For debugging
                $('form')[0].reset(); // reset the form
            },
            error: function(xhr, status, error) {
                // Handle error
                alert('Erreur lors de la soumission du formulaire.');
                console.error(error);
            }
        });
    });
});
</script>

