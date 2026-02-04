<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.all.min.js"></script>

<style>
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('assets/images/bg.jpg') no-repeat center center/cover;
    z-index: -2;
}

body::after {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4); /* black overlay, adjust opacity */
    z-index: -1;
}/* Card styling for modern look */
.card {
    background: rgb(16 33 71 / 40%); /* semi-transparent white */
    backdrop-filter: blur(10px); /* blur behind card */
    border-radius: 1rem; /* rounded corners */
    border: 1px solid rgba(255, 255, 255, 0.3); /* subtle border */
    box-shadow: 0 8px 24px rgba(0,0,0,0.2); /* shadow */
    padding: 1.5rem; /* inner spacing */
    transition: transform 0.2s, box-shadow 0.2s;
}

/* Hover effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.3);
}

/* Optional: input styling for glass effect */
.form-control, .form-select {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(0,0,0,0.2);
}
.form-label{
    color: #c9c9c9;
}
.text-muted {
    color: #ffffff !important;
}
/* Buttons with shadow */
.btn-primary {
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.btn-primary:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.3);
}
</style>
<div class="container my-5" style="max-width: 1100px;">

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h5 class=" fw-bold" style="color:#44d2f6">Remplissez le formulaire</h5>

        <p class="text-muted mb-0">Veuillez renseigner les informations demandées avec exactitude</p>
    </div>

    <form method="post" action="traitement.php">

        <!-- Choix du site -->
        <div class="card border-1 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4 text-white">Choix du site</h5>

              <div id="rows-container">

    <!-- ROW TEMPLATE -->
    <div class="row g-3 align-items-end form-row">
        <div class="col-md-3">
            <label class="form-label">Wilaya</label>
            <select class="form-select" name="wilaya[]">
                <option value="">Choisir...</option>
                <option value="16">Alger</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Projet</label>
            <select class="form-select" name="projet[]">
                <option value="">Choisir...</option>
                <option value="Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)">
                    Résidence Scolaria – 54 logements avec parking et 8 locaux commerciaux (BAB EZZOUAR)
                </option>
                <option>
                    30 logements promotionnels avec parking et 8 locaux commerciaux (REGHAIA)
                </option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Typologie</label>
            <select class="form-select" name="typologie[]">
                <option value="">Choisir...</option>
                <option value="F3">F3</option>
                <option value="F4">F4</option>
                <option value="F5">F5</option>
                <option value="Place de stationnement">Place de stationnement</option>
                <option value="Local commercial">Local commercial</option>
            </select>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="col-md-2 d-flex gap-2">
            <button type="button" class="btn btn-success add-row">
                +
            </button>
        </div>
    </div>

    <script>
document.addEventListener("click", function (e) {

    // ADD ROW
    if (e.target.classList.contains("add-row")) {
        const row = e.target.closest(".form-row");
        const clone = row.cloneNode(true);

        // reset values
        clone.querySelectorAll("select").forEach(select => {
            select.value = "";
        });

        // change buttons
        const btnContainer = clone.querySelector(".col-md-2");
        btnContainer.innerHTML = `
            <button type="button" class="btn btn-danger remove-row">−</button>
        `;

        document.getElementById("rows-container").appendChild(clone);
    }

    // REMOVE ROW
    if (e.target.classList.contains("remove-row")) {
        e.target.closest(".form-row").remove();
    }
});
</script>

</div>

            </div>
        </div>

        <!-- Souscripteur -->
        <div class="card border-1 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-4 text-white">Informations concernant le souscripteur</h5>

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
                        <input type="text" class="form-control" name="nin" id="nin" inputmode="numeric" maxlength="18" required>
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
                <h5 class="fw-bold mb-4 text-white">Vérification et confirmation</h5>
 
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
                    <input class="form-check-input" type="checkbox" id="confirm1" name="confirm1" required>
                    <label class="form-check-label fw-bold text-danger" for="confirm1">
                        Je confirme que toutes les informations sont justes.
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirm2" name="confirm2" required>
                    <label class="form-check-label" for="confirm2" style="color:#fff;">
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

function wilayas(){
    $.ajax({
        url:'assets/php/wilayas.php',
        type:'GET',
        success:function(response){
            let data = JSON.parse(response);
            let select = $('select[name="wilaya"]');
            data.forEach(function(wilaya){
                let option = $('<option></option>').attr('value', wilaya.id).text(wilaya.name);
                select.append(option);
            });
        }
    })
}
//wilayas()
</script>
<script>
  $(document).ready(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize(); // ✅ keeps arrays

        $.ajax({
            url: 'assets/php/inscription.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.response === 'true') {
                    window.location.href = 'confirmation.php';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message
                    });
                }

                console.log(response);
            },
            error: function () {
                alert('Erreur lors de la soumission du formulaire.');
            }
        });
    });
});

</script>

<script>
$(document).ready(function() {
    $(document).on('input', '#nin', function() {
        console.log('Input event triggered');
        this.value = this.value.replace(/\D/g, '').substring(0, 18);
    });
});
</script>