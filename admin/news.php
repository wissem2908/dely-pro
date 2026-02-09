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
                    <h5 class="m-b-10">Actualités</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Actualités</li>
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
            <div class='row'>
                <div class="col-lg-12">
                    <div class="card shadow-sm">

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Actualités</h5>
                                <a href="add_news.php" class="btn btn-primary">Ajouter une actualité</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="newsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Image</th>
                                            <th>Lien</th>
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
    $(document).ready(function() {

        function loadNews() {
            $.ajax({
                url: 'assets/php/news/get_news.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    let html = '';


                    function limitText(html, maxLength = 120) {
                        // Remove HTML tags
                        let text = $('<div>').html(html).text();

                        // Trim spaces
                        text = text.trim();

                        // Limit length
                        if (text.length > maxLength) {
                            text = text.substring(0, maxLength) + '...';
                        }

                        return text;
                    }



                    if (data.length === 0) {
                        html = `
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Aucune actualité trouvée
                            </td>
                        </tr>`;
                    } else {

                        $.each(data, function(index, item) {

                            let image = item.image ?
                                `<img src="assets/uploads/news_images/${item.image}" width="60" class="rounded">` :
                                '<span class="text-muted">—</span>';

                            let link = item.slug ?
                                `<a href="../news_details.php?slug=${item.slug}" target="_blank"><i class="feather feather-eye"></i></a>` :
                                '<span class="text-muted">—</span>';

                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.title}</td>
                                <td>${limitText(item.description, 80)}</td>
                                <td>${item.date_fr}</td>
                                <td>${image}</td>
                                <td>${link}</td>
                               <td>
                                                <div class="d-inline-flex gap-2">
                                                    <button class="btn btn-sm btn-outline-primary edit-news" id="editNewsBtn"
                                                            data-id="${item.id}" title="Modifier">
                                                        <i class="feather feather-edit-2"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-outline-danger delete-news" id="deleteNewsBtn"
                                                            data-id="${item.id}" title="Supprimer">
                                                        <i class="feather feather-trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                            </tr>
                        `;
                        });
                    }

                    $('#newsTable tbody').html(html);
                },
                error: function() {
                    alert('Erreur lors du chargement des actualités');
                }
            });
        }

        loadNews();



        /******************************** delete btn *************************************** */
$(document).on('click', '#deleteNewsBtn', function() {
    let newsId = $(this).data('id');

    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action supprimera définitivement l'actualité !",
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
                url: 'assets/php/news/delete_news.php',
                type: 'POST',
                data: { id: newsId },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé !',
                        text: 'L\'actualité a été supprimée.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadNews(); // refresh the news list
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
});
/*************************************** edit news *********************************************** */

$(document).on('click', '#editNewsBtn', function(){
    let newsId = $(this).data('id');
    window.location.href = `news_edit.php?id=${newsId}`;
})

/************************************************************************************************** */
    });
</script>