<?php

include('includes/header.php');
?>


<style>
    .custom-file, .custom-select, .form-control, .form-select, input {
        padding: 0px;
    }
</style>

<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Demandes d'inscription</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Demandes d'inscription</li>
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
                                            <th class="">
                                                Référence
                                            </th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Téléphone</th>
                                            <th>Email</th>
                                            <th>Date d'inscription</th>
                                            <th>Etat</th>
                                            <th class="text-end">Actions</th>
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

<div class="modal fade" id="motifModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Motif du refus</h5>
            </div>
            <div class="modal-body">
                <textarea id="motifText" class="form-control" rows="4"
                    placeholder="Motif obligatoire..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmRefus">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>
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

        function getClients() {
            $.ajax({
                url: "assets/php/clients/get_clients.php",
                method: "GET",
                success: function(response) {
               

                    var data = JSON.parse(response);
                    var list = "";

                    for (var i = 0; i < data.length; i++) {
                        list += `<tr>
                                 <td>    ${data[i].reference}</td>
                                    <td>    ${data[i].nom}</td>
                                     <td>    ${data[i].prenom}</td>
                                     <td>    ${data[i].telephone}</td>
                                     <td>${data[i].email}</td>
                                     <td> ${data[i].created_at}</td>
                              <td>
                                <div class="badge status-badge
                                    ${data[i].statut === 'en_attente' ? 'bg-soft-warning text-warning' : ''}
                                    ${data[i].statut === 'en_cours' ? 'bg-soft-info text-info' : ''}
                                    ${data[i].statut === 'valide' ? 'bg-soft-success text-success' : ''}
                                    ${data[i].statut === 'refuse' ? 'bg-soft-danger text-danger' : ''}">
                                    ${data[i].statut.replace('_',' ')}
                                </div>

                                <select class="form-select form-select-sm mt-1 change-status"
                                        data-id="${data[i].id}">
                                    <option value="en_attente" ${data[i].statut === 'en_attente' ? 'selected' : ''}>En attente</option>
                                    <option value="en_cours" ${data[i].statut === 'en_cours' ? 'selected' : ''}>En cours</option>
                                    <option value="valide" ${data[i].statut === 'valide' ? 'selected' : ''}>Validé</option>
                                    <option value="refuse" ${data[i].statut === 'refuse' ? 'selected' : ''}>Refusé</option>
                                </select>
                            </td>

                                     <td>
                                     <a href="proposal-view.html" class="avatar-text avatar-md">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
                                                        </td>
                                </tr>`

                    }
                    $("#proposalList tbody").append(list)
                    $("#proposalList").DataTable({
                        destroy: true,
                        order: [],
                        pageLength: 10,
                        lengthMenu: [10, 20, 50, 100, 200, 500]
                    });


                }
            })
        }

        getClients()
    })
    /************************************** end list clients *********************************************** */



    /*************************************** CHANGE STATUS ***************************************************/

    let currentId = null;

    // $(document).on('change', '.change-status', function() {
    //     const status = $(this).val();
    //     currentId = $(this).data('id');

    //     if (status === 'refuse') {
    //         $('#motifText').val('');
    //         $('#motifModal').modal('show');
    //     } else {
    //         updateStatus(currentId, status, null);
    //     }
    // });

    // $('#confirmRefus').on('click', function() {
    //     const motif = $('#motifText').val().trim();

    //     if (!motif) {
    //         alert('Motif obligatoire');
    //         return;
    //     }

    //     updateStatus(currentId, 'refuse', motif);
    //     $('#motifModal').modal('hide');
    // });


    /************************************************************* */

    function updateStatus(id, statut, motif) {
        $.ajax({
            url: "assets/php/clients/update_status.php",
            method: "POST",
            dataType: "json",
            data: {
                id: id,
                statut: statut,
                motif: motif
            },
            success: function(res) {
                if (!res.success) {
                    alert(res.message);
                }
            }
        });
    }

    /*********************************************************** */
    function updateBadge(selectEl, status) {
    const badge = $(selectEl).closest('td').find('.status-badge');

    badge
        .removeClass(
            'bg-soft-warning text-warning ' +
            'bg-soft-info text-info ' +
            'bg-soft-success text-success ' +
            'bg-soft-danger text-danger'
        );

    const map = {
        en_attente: ['bg-soft-warning', 'text-warning', 'En attente'],
        en_cours: ['bg-soft-info', 'text-info', 'En cours'],
        valide: ['bg-soft-success', 'text-success', 'Validé'],
        refuse: ['bg-soft-danger', 'text-danger', 'Refusé']
    };

    badge
        .addClass(map[status][0] + ' ' + map[status][1])
        .text(map[status][2]);
}

/************************************************************* */
$(document).on('change', '.change-status', function () {
    const status = $(this).val();
    const id = $(this).data('id');
    const selectEl = this;

    if (status === 'refuse') {
        currentId = id;
        currentSelect = selectEl;
        $('#motifText').val('');
        $('#motifModal').modal('show');
    } else {
        updateBadge(selectEl, status); // ✅ instant UI update
        updateStatus(id, status, null);
    }
});
/******************************* MOTIF TEXT **************************************** */
let currentSelect = null;

$('#confirmRefus').on('click', function () {
    const motif = $('#motifText').val().trim();

    if (!motif) {
        alert('Motif obligatoire');
        return;
    }

    updateBadge(currentSelect, 'refuse'); // ✅ badge turns red
    updateStatus(currentId, 'refuse', motif);
    $('#motifModal').modal('hide');
});
</script>