<?php
// index.php — start of file

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Role check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: demandes.php');
    exit;
}

// Only now include HTML output
include 'includes/header.php';
?>


<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Informations du client</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Informations du client</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                        <div class="d-flex ">
            <a href="javascript:void(0)" onclick="goBack()" class="page-header-right-close-toggle">
              <i class="feather-arrow-left me-2"></i>
              <span>Retour</span>
            </a>
            <script>
              function goBack() {
                window.history.back();
              }
            </script>
          </div>


                </div>

            </div>
        </div>
        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        <div class="main-content">

            <div class="row">

<form id="editClientForm">

                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="feather feather-file-text me-2"></i>
                                Modifier les informations du client
                            </h5>
                        </div>

                        <div class="card-body">

                            <input type="hidden" name="client_id" id="client_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">

                            <div class="card">
                                <div class="card-header">Choix du site</div>
                                <div class="card-body">
                                    <div id="rows-container">
                                        <div class="row form-row">
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
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-sm btn-success add-row" style="height: 38px;margin-top:30px">
                                                    +
                                                </button>
                                            </div>

                                            <script>
                                                document.addEventListener("click", function(e) {

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
                                                    <button type="button" class="btn btn-danger remove-row" style="height: 38px;margin-top:30px">−</button>
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


                            </div>

                            <div class="card">
                                <div class="card-header">Informations concernant le souscripteur</div>
                                <div class="card-body">

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
                                                <option value="Marié(e)" >Marié(e)</option>
                                                <option value="Divorcé(e)">Divorcé(e)</option>
                                                <option value="Veuf(ve)">Veuf(ve)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>



                            </div>


                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="news.php" class="btn btn-light">
                                    <i class="feather feather-x"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather feather-save"></i> Enregistrer
                                </button>
                            </div>


                        </div>
                    </div>
                </div>


</form>
                <!--! END: [Team Progress] !-->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
    <!-- [ Footer ] start -->
    <!-- <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
            <p><span>By: <a target="_blank" href="https://wrapbootstrap.com/user/theme_ocean" target="_blank">theme_ocean</a></span> • <span>Distributed by: <a target="_blank" href="https://themewagon.com" target="_blank">ThemeWagon</a></span></p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer> -->
    <!-- [ Footer ] end -->
</main>
<!--! ================================================================ !-->
<!--! [End] Main Content !-->
<!--! ================================================================ !-->
<!--! ================================================================ !-->
<!--! BEGIN: Theme Customizer !-->
<!--! ================================================================ !-->

<!--! ================================================================ !-->
<!--! [End] Theme Customizer !-->
<!--! ================================================================ !-->
<!--! ================================================================ !-->
<!--! Footer Script !-->
<!--! ================================================================ !-->
<!--! BEGIN: Vendors JS !-->

<?php
include('includes/footer.php');
?>

<script>
$(document).ready(function () {


/************************************* get client's informations********************************** */


function getClientData(){

$.ajax({
    url: 'assets/php/clients/get_client_by_id.php',
    type: 'POST',
    data: { clientId: $('#client_id').val() },
    dataType: 'json',

    success: function (response) {

        if (response.length > 0) {
            const client = response[0];
            console.log(client);

            // Populate form fields
            $('select[name="wilaya[]"]').val(client.wilaya);
            $('select[name="projet[]"]').val(client.projet);
            $('select[name="typologie[]"]').val(client.typologie);
            $('input[name="nom"]').val(client.nom);
            $('input[name="prenom"]').val(client.prenom);
            $('input[name="date_naissance"]').val(client.date_naissance);
            $('input[name="type_date"]').val(client.type_date_naissance);
            $('input[name="nin"]').val(client.nin);
            $('input[name="adresse"]').val(client.adresse);
            $('input[name="tel"]').val(client.telephone);
            $('input[name="email"]').val(client.email);
            $('select[name="situation"]').val(client.situation_matrimoniale);

        } else {
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Erreur',
            //     text: 'Client non trouvé'
            // }).then(() => {
            //     window.location.href = 'clients.php';
            // });
        }
    },

    error: function () {
        Swal.fire({
            icon: 'error',
            title: 'Erreur serveur',
            text: 'Impossible de contacter le serveur.'
        });
    }
});

/*************** choix du site ****************** */

$.ajax({
    url:'assets/php/clients/get_client_sites.php',
    type:'POST',
    data:{ clientId: $('#client_id').val() },
    dataType:'json',
    success:function(response){
        console.log(response);
        var data = response;
   
        for(var i= 0; i< data.length; i++){
            if(i == 0){
                // fill the first row
                $('select[name="wilaya[]"]').eq(0).val(data[i].wilaya);
                $('select[name="projet[]"]').eq(0).val(data[i].projet);
                $('select[name="typologie[]"]').eq(0).val(data[i].typologie);
            } else {
                // add new rows for additional sites
                $('.add-row').first().click(); // trigger add row

                // fill the newly added row
                $('select[name="wilaya[]"]').last().val(data[i].wilaya);
                $('select[name="projet[]"]').last().val(data[i].projet);
                $('select[name="typologie[]"]').last().val(data[i].typologie);
        }
        
    }
}
})
}
getClientData()
/*************************************************************************************************** */

    $('#editClientForm').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize(); 
        // serialize keeps arrays: wilaya[], projet[], typologie[]

        $.ajax({
            url: 'assets/php/clients/update_client.php',
            type: 'POST',
            data: formData,
            dataType: 'json',

            success: function (response) {

                if (response.message === 'update_success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: 'Client modifié avec succès'
                    }).then(() => {
                        //window.location.href = 'clients.php';
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: response.message
                    });
                }
            },

            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur serveur',
                    text: 'Impossible de contacter le serveur.'
                });
            }
        });
    });

});
</script>