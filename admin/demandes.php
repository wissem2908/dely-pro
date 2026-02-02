<?php

include('includes/header.php');
?>
<!-- <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
  rel="stylesheet"
/> -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<style>
  /* Wizard Styles */
  .wizard-card {
    border-radius: 14px;
  }

  .wizard-steps {
    position: relative;
  }

  .step {
    text-align: center;
    width: 120px;
    z-index: 2;
  }

  .step span {
    display: block;
    margin-top: 6px;
    font-size: 14px;
    color: #aaa;
  }

  .step.active span,
  .step.completed span {
    color: #0d6efd;
    font-weight: 600;
  }

  .circle {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    font-size: 18px;
    color: #999;
  }

  .step.active .circle {
    background: #0d6efd;
    color: #fff;
  }

  .step.completed .circle {
    background: #198754;
    color: #fff;
  }

  .line {
    flex: 1;
    height: 2px;
    background: #e9ecef;
    margin-top: 22px;
  }

  .step.completed+.line {
    background: #198754;
  }

  /* Info Boxes */
  .info-box {
    background: #f8f9fa;
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 12px;
  }

  .info-box label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 2px;
    display: block;
  }

  .info-box p {
    margin: 0;
    font-weight: 600;
  }

  .table th,
  .table td {
    vertical-align: middle;
  }
</style>

<main class="nxl-container">
  <div class="nxl-content">
    <!-- [ page-header ] start -->
    <div class="page-header">
      <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
          <h5 class="m-b-10">Dashboard</h5>
        </div>
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Dashboard</li>
        </ul>
      </div>
      <div class="page-header-right ms-auto">
        <div class="page-header-right-items">
          <div class="d-flex d-md-none">
            <a href="javascript:void(0)" class="page-header-right-close-toggle">
              <i class="feather-arrow-left me-2"></i>
              <span>Back</span>
            </a>
          </div>

        </div>

      </div>
    </div>
    <!-- [ page-header ] end -->
    <!-- [ Main Content ] start -->
    <div class="main-content">
      <div class="row">


        <div class="my-5">
          <div class="card wizard-card shadow-lg">
            <div class="card-body p-4">
              <h3 class="text-center mb-1">Suivi de l’inscription</h3>
              <p class="text-center text-muted mb-4">
                Gestion du traitement administratif
              </p>

              <!-- STEPPER -->
              <div class="wizard-steps d-flex justify-content-between mb-5">
                <div class="step active" data-step="1">
                  <div class="circle"><i class="fa fa-user"></i></div>
                  <span>Informations</span>
                </div>
                <div class="line"></div>
                <div class="step " data-step="2">
                  <div class="circle"><i class="fa fa-gear"></i></div>
                  <span>Traitement</span>
                </div>
                <div class="line"></div>
                <div class="step" data-step="3">
                  <div class="circle"><i class="fa fa-check"></i></div>
                  <span>Décision</span>
                </div>
              </div>

              <!-- STEP 1: Client Info -->
              <div class="wizard-content" id="step-1">
                <h5>Informations du client</h5>
                <hr />

                <div class="row">
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>Nom</label>
                      <p id="nom-client">Dupont</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>Prénom</label>
                      <p id="prenom-client">Jean</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>Date de naissance</label>
                      <p id="date-naissance">1985-07-23 (Né(e))</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>NIN</label>
                      <p id="nin-client">AB123456789</p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="info-box">
                      <label>Adresse</label>
                      <p id="adresse-client">12 Rue des Fleurs, Alger</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>Téléphone</label>
                      <p id="telephone-client">+213 550 123 456</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>Email</label>
                      <p id="email-client">jean.dupont@example.com</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="info-box">
                      <label>Situation matrimoniale</label>
                      <p id="situation-matrimoniale">Célibataire</p>
                    </div>
                  </div>
                </div>

                <hr />
                <!-- Dossier à fournir -->
                <h6 class="mt-4">Dossier à fournir</h6>
                <div class="row g-3">
                  <div class="col-md-3">
                    <label for="fiche_renseignement" class="form-label">Fiche de renseignement</label>
                    <a href="#" class="form-control"> Document à telechargé</a>
                    <!-- <input type="file" class="form-control" id="fiche_renseignement" name="fiche_renseignement" accept=".pdf,.doc,.docx"> -->
                  </div>
                  <div class="col-md-3">
                    <label for="piece_identite" class="form-label">Pièce d'identité</label>
                    <input
                      type="file"
                      class="form-control"
                      id="piece_identite"
                      name="piece_identite"
                      accept=".pdf,.jpg,.png" />
                    <a href="#" target="_blank" class="text-primary d-none" id="view_piece_identite">
                      👁 Voir le document
                    </a>
                  </div>
                  <div class="col-md-3">
                    <label for="extrait_naissance" class="form-label">Extrait de naissance</label>
                    <input
                      type="file"
                      class="form-control"
                      id="extrait_naissance"
                      name="extrait_naissance"
                      accept=".pdf,.jpg,.png" />
                    <a href="#" target="_blank" class="text-primary d-none" id="view_extrait_naissance">
                      👁 Voir le document
                    </a>
                  </div>


                  <div class="col-md-3">
                    <label class="form-label"> &nbsp;</label>
                    <button class="btn btn-secondary " id="files-btn"> Uploader</button>
                  </div>

                </div>

                <!-- Sites -->
                <h6 class="mt-4">Choix du site</h6>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>#</th>
                        <th>Wilaya</th>
                        <th>Projet</th>
                        <th>Typologie</th>
                      </tr>
                    </thead>
                    <tbody id="sites-table-body">
                      <tr>
                        <td>1</td>
                        <td>Alger</td>
                        <td>Résidence Scolaria – 54 logements</td>
                        <td>F3</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Oran</td>
                        <td>30 logements promotionnels</td>
                        <td>F4</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Blida</td>
                        <td>19 logements avec commerces</td>
                        <td>Local commercial</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- <span id="statut-client" class="badge bg-warning">En attente</span> -->

                <!-- <div class="text-end mt-4">
              <button class="btn btn-primary next-step" data-next="2">
                Continuer
              </button>
            </div> -->
              </div>

              <!-- STEP 2 -->
<div class="wizard-content d-none" id="step-2">
    <h5>Traitement du dossier</h5>
    <hr />

    <!-- Status badge -->
    <span class="badge bg-info mb-3">En cours de traitement</span>

    <!-- Description -->
    <p>
        Votre dossier est actuellement en cours de traitement par notre équipe administrative.
        Les documents que vous avez soumis sont en cours de vérification et validation.
    </p>

    <!-- Progress timeline -->
    <!-- <div class="mt-4 mb-3">
        <h6>Étapes du traitement :</h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Vérification des documents
                <span class="badge bg-success rounded-pill"><i class="fa fa-check"></i></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Validation des informations personnelles
                <span class="badge bg-warning rounded-pill"><i class="fa fa-spinner fa-spin"></i></span>
            </li>
         
        </ul>
    </div> -->


    <!-- Notes or instructions -->
    <div class="mt-3 text-muted" style="font-size: 13px;">
        <p>
            Une fois le dossier validé, vous passerez à l'étape <b>Décision finale</b>.
            Si des informations sont manquantes ou incorrectes, l'équipe pourra vous contacter pour compléter le dossier.
        </p>
    </div>
</div>


              <!-- STEP 3 -->
            <div class="wizard-content d-none" id="step-3">
    <h5>Décision finale</h5>
    <hr />

    <div id="finalResult" class="mt-3">

        <!-- Validé -->
        <div class="final-valid d-none text-center">
            <span class="badge bg-success mb-3">Dossier Validé</span>
            <p>
                Félicitations ! Votre dossier a été validé avec succès.
                Vous pouvez maintenant passer aux étapes suivantes de votre inscription ou prendre rendez-vous si nécessaire.
            </p>
            <ul class="list-group list-group-flush text-start mt-3">
                <li class="list-group-item"><i class="fa fa-check text-success me-2"></i> Votre dossier est complet et conforme.</li>
                <li class="list-group-item"><i class="fa fa-check text-success me-2"></i> Aucune action supplémentaire n’est requise.</li>
                <li class="list-group-item"><i class="fa fa-check text-success me-2"></i> Vous serez contacté(e) pour les prochaines étapes si nécessaire.</li>
            </ul>
        </div>

        <!-- Refusé -->
        <div class="final-refuse d-none text-center">
            <span class="badge bg-danger mb-3">Dossier Refusé</span>
            <p>
                Malheureusement, votre dossier a été refusé. Veuillez consulter le motif ci-dessous et prendre les mesures nécessaires.
            </p>
            <div class="alert alert-danger mt-3" id="motif-refus">
                <!-- Motif du refus dynamique via JS -->
            </div>
            <p class="text-muted mt-2" style="font-size: 13px;">
                Si vous corrigez les informations ou documents manquants, vous pouvez soumettre à nouveau votre dossier.
            </p>
        </div>

    </div>
</div>
            </div>
          </div>
        </div>



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

<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->

<script>
  $(document).ready(function() {

    $.ajax({
      url: "assets/php/clients/get_inscription_data.php",
      type: "GET",

      success: function(res) {
        console.log(res)

        // if (res.status !== "success") {
        //     alert(res.message);
        //     return;
        // }


        const u = JSON.parse(res)
        console.log(u.nom)
        $("#nom-client").text(u.nom);
        $("#prenom-client").text(u.prenom);
        $("#date-naissance").text(
          u.date_naissance + " (" + (u.type_date_naissance === "N" ? "Né(e)" : "Prévu(e)") + ")"
        );
        $("#nin-client").text(u.nin);
        $("#adresse-client").text(u.adresse);
        $("#telephone-client").text(u.telephone);
        $("#email-client").text(u.email ?? "-");
        $("#situation-matrimoniale").text(u.situation_matrimoniale);

        // Status badge
        let badgeClass = {
          en_attente: "bg-warning",
          en_cours: "bg-info",
          valide: "bg-success",
          refuse: "bg-danger"
        } [u.statut] || "bg-secondary";

        $("#statut-client")
          .removeClass()
          .addClass("badge " + badgeClass)
          .text(u.statut.replace("_", " "));


          /***************************** status ******************************* */
if(u.statut === 'en_cours'){
$('.step[data-step="2"]').addClass('active');

 $('.step[data-step="1"]').addClass('completed');
}
else if(u.statut === 'valide' || u.statut === 'refuse'){
$('.step[data-step="2"]').addClass('active');
$('.step[data-step="3"]').addClass('active');
 $('.step[data-step="1"]').addClass('completed');
 $('.step[data-step="2"]').addClass('completed');
}


if(u.statut === 'valide'){
    $('#finalResult .final-valid').removeClass('d-none');
     $('.step[data-step="3"]').addClass('completed');

     $('.step[data-step="3"].completed .circle')
    .css('background', '#198754')      // green background
    .css('color', '#fff')              // white icon
    .html('<i class="fa fa-check"></i>'); // set icon to check
} 
else if(u.statut === 'refuse'){
    $('#finalResult .final-refuse').removeClass('d-none');
    $('#motif-refus').text(u.motif_refus || "Motif non fourni");
 $('.step[data-step="3"]').addClass('completed');
    // For refused status (red)
$('.step[data-step="3"].completed .circle')
    .css('background', '#dc3545')      // red background
    .css('color', '#fff')              // white icon
    .html('<i class="fa fa-times"></i>'); // set icon to X
}

$('.step').click(function() {
    if (!$(this).hasClass('active')) return; // only active steps respond
    let step = $(this).data('step');
    $('.wizard-content').addClass('d-none');
    $('#step-' + step).removeClass('d-none');
});

        /**************************** table choix site **************************** */


        $.ajax({
          url: "assets/php/clients/get_choix_site.php",
          type: "POST",
          data: {
            id_inscription: u.id
          },
          success: function(siteRes) {
            const sites = JSON.parse(siteRes);
            console.log(u.id)
            let sitesHtml = "";
            sites.forEach((site, index) => {
              sitesHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${site.name}</td>
                                    <td>${site.projet}</td>
                                    <td>${site.typologie}</td>
                                </tr>
                            `;
            });
            $("#sites-table-body").html(sitesHtml);
          },
          error: function() {
            alert("Erreur de chargement des choix de site");
          }
        });
      },
      error: function() {
        alert("Erreur de chargement des données");
      }
    });


    /**************************************** uploads files ******************************************************* */

    $('#files-btn').click(function(e) {
      e.preventDefault();

      let formData = new FormData();

      let pieceIdentite = $('#piece_identite')[0].files[0];
      let extraitNaissance = $('#extrait_naissance')[0].files[0];

      formData.append('piece_identite', pieceIdentite);
      formData.append('extrait_naissance', extraitNaissance);
      $.ajax({
        url: 'assets/php/clients/upload_documents.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          alert('Fichiers téléchargés avec succès');
        },
        error: function() {
          alert('Erreur lors du téléchargement des fichiers');
        }
      });

    })


    /**************************************** view uploaded files ******************************************************* */

        // Load existing uploaded files
    $.ajax({
        url: 'assets/php/clients/get_uploaded_files.php',
        type: 'GET',
        dataType: 'json',
        success: function(files) {
            // files is like { piece_identite: "path/to/file.pdf", extrait_naissance: "path/to/file.jpg" }
            console.log(files);

            if(files.piece_identite) {
            
              console.log(files.piece_identite);

                $('#view_piece_identite')
                    .attr('href',"../assets/uploads/files_uploads/"+ files.piece_identite)
                    .removeClass('d-none');
            }

            if(files.extrait_naissance) {
                $('#view_extrait_naissance')
                    .attr('href', "../assets/uploads/files_uploads/"+files.extrait_naissance)
                    .removeClass('d-none');
            }
        },
        error: function() {
            console.log("Erreur lors de la récupération des fichiers");
        }
    });


  });
</script>
<script>
// $(function () {

//     function goToStep(step) {
//         $('.wizard-step').addClass('d-none');
//         $('#step-' + step).removeClass('d-none');

//         $('#wizardSteps .nav-link').addClass('disabled').removeClass('active');
//         $('#wizardSteps .nav-link[data-step="' + step + '"]')
//             .removeClass('disabled')
//             .addClass('active');
//     }

//     $('.next-step').on('click', function () {
//         let nextStep = $(this).data('next');
//         let status = $(this).data('status') || 'en_cours';

//         updateStatus(status, null, function () {
//             goToStep(nextStep);
//         });
//     });

//     $('.refuse-btn').on('click', function () {
//         let motif = prompt("Motif du refus :");
//         if (!motif) return;

//         updateStatus('refuse', motif, function () {
//             $('#validationResult').html(
//                 '<span class="badge bg-danger">Refusé</span><p><b>Motif :</b> ' + motif + '</p>'
//             );
//             goToStep(3);
//         });
//     });



// });
</script>