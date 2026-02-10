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
                    <h5 class="m-b-10">Appels d'offres</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Appels d'offres</li>
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

                <div class="col-lg-12">
                    <div class="card shadow-sm">

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Appels d'offres</h5>
                                <a href="add_offers.php" class="btn btn-primary">Ajouter un appel d'offre</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                </div>



                <!--! END: [Team Progress] !-->
            </div>

                        <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="offersTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Document</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- rempli par AJAX -->
                                    </tbody>
                                </table>
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

<script>

    $(document).ready(function(){

    function getOffers(){
            $.ajax({
                url:'assets/php/offers/get_offers.php',
                method:'GET',
                success:function(response){
                    console.log(response)

                    var data = JSON.parse(response);

                    var offers="";

                    for(var i=0; i< data.length; i++){
                        offers+=`<tr>
                        <td>${i+1}</td>
                        <td>${data[i].title}</td>
                        <td>${data[i].description}</td>
                        <td>${data[i].date_fr}</td>
                        <td class="text-center"><a href="./assets/uploads/appels_offres/${data[i].file_path}" target="_blank"><i class="feather feather-eye"></i></a></td>
                        <td class="text-center">
                          <div class="d-inline-flex gap-2">
                            <a class="btn btn-sm btn-outline-primary" href="edit_offers.php?id=${data[i].id}">  <i class="feather feather-edit-2"></i></a>
                            <button class="btn btn-sm btn-outline-danger deleteOfferBtn" id="deleteOfferBtn" data-id="${data[i].id}"><i class="feather feather-trash-2"></i></button>
                            </div>
                        </td>
                        </tr>`
                    }

                    $('#offersTable tbody').html(offers);
                }
            })
    }

    getOffers()


    /********************************  DELETE OFfERS*********************************** */

    $(document).on('click','#deleteOfferBtn',function(){
        var id = $(this).data('id');

    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action supprimera définitivement l'appel d'offres !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6', // blue
        cancelButtonColor: '#d33',     // red
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
         if (result.value) {
            // Proceed with deletion
            $.ajax({
                url: 'assets/php/offers/delete_offers.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé !',
                        text: 'L\'appel d\'offres a été supprimé.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    getOffers(); // refresh the offers list
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de la suppression.'
                    });
                }


            });
}
       
    });

    })
    })
</script>