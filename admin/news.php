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

                            let link = item.link ?
                                `<a href="${item.link}" target="_blank"><i class="feather feather-eye"></i></a>` :
                                '<span class="text-muted">—</span>';

                            html += `
                            <tr>
                                <td>${item.id}</td>
                                <td>${item.title}</td>
                                <td>${item.description.substring(0, 80)}...</td>
                                <td>${item.date_fr}</td>
                                <td>${image}</td>
                                <td>${link}</td>
                               <td>
    <div class="d-inline-flex gap-2">
        <button class="btn btn-sm btn-outline-primary edit-news"
                data-id="${item.id}" title="Modifier">
            <i class="feather feather-edit-2"></i>
        </button>

        <button class="btn btn-sm btn-outline-danger delete-news"
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
    });
</script>