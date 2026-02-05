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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.18/dist/sweetalert2.all.min.js"></script>

<style>
    .custom-file,
    .custom-select,
    .form-control,
    .form-select,
    input {
        padding: 0px;
    }
</style>

<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Demandes archivées</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Demandes archivées</li>
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
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="proposalList">
                                    <thead>
                                        <tr>
                                            <th class="">Référence</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Téléphone</th>
                                            <th>Email</th>
                                            <th>Date d'inscription</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>










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
    // "use strict";
    // $(document).ready(function() {
    //     $("#proposalList").DataTable({
    //         pageLength: 10,
    //         lengthMenu: [10, 20, 50, 100, 200, 500]
    //     })
    // })


    /************************************** list clients *************************************************** */



    $(document).ready(function() {
        var table = $("#proposalList").DataTable({
            order: [],
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100, 200, 500]
        });

        function getClients() {
            $.ajax({
                url: "assets/php/clients/get_archived_clients.php",
                method: "GET",
                success: function(response) {


                    var data = JSON.parse(response);
                    var list = "";
                    table.clear(); // 🔥 clear existing rows
                    for (var i = 0; i < data.length; i++) {
                        list += `<tr>
                                 <td>    ${data[i].reference}</td>
                                    <td>    ${data[i].nom}</td>
                                     <td>    ${data[i].prenom}</td>
                                     <td>    ${data[i].telephone}</td>
                                     <td>${data[i].email}</td>
                                     <td> ${data[i].created_at}</td>
                      

                                     <td class="text-center">
                                     <a href="demandes.php?id=${data[i].id}" class="avatar-text avatar-md d-inline-flex justify-content-center align-items-center">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
<a href="#"
   id="restoreClient-${data[i].id}"
   data-id="${data[i].id}"
   class="avatar-text avatar-md d-inline-flex justify-content-center align-items-center">
    <i class="feather feather-refresh-ccw"></i>
</a>
                                                        </td>
                                </tr>`

                    }
                    table.draw(); // 🔥 redraw safely
                    $("#proposalList tbody").empty()
                    $("#proposalList tbody").append(list)


                }
            })
        }

        getClients()

        /************************************** end list clients *********************************************** */




        /***************************** restore client************************************************ */
        $(document).on('click', '[id^="restoreClient-"]', function(e) {
            e.preventDefault();

            let clientId = $(this).data('id');

            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, restaurer !"
            }).then((result) => {



                $.ajax({
                    url: 'assets/php/clients/restore_client.php',
                    method: 'POST',
                    data: {
                        clientId: clientId
                    },
                    success: function(response) {
                        console.log(typeof response);


                        if (response == true) {
                            console.log(response);
                            getClients(); // refresh table
                            Swal.fire({
                                title: "Restauré !",
                                text: "Le client a été restauré.",
                                icon: "success"
                            });


                        }
                    }
                });



            });
        });



    })
    /************************************************************* */
</script>