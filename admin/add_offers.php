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
<style>
    .ck-editor__editable {
        min-height: 400px !important;
    }
</style>

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



                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="feather feather-file-text me-2"></i>
                              Nouvel appel d’offres
                            </h5>
                        </div>

                        <div class="card-body">
                            <form id="offersForm" enctype="multipart/form-data">

                                <!-- Title -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        Titre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>

                                <!-- Date -->
                                <!-- <div class="mb-3">
                    <label class="form-label">
                        Date <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="date" class="form-control" required>
                </div> -->

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        Description <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description" class="form-control" style="min-height: 300px !important;"></textarea>
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label">Document</label>
                                    <input type="file" name="document" id="documentInput" class="form-control" accept="application/pdf">
                                </div>

                                <!-- Preview -->
                                <!-- <div class="mb-3">
                                    <img id="imagePreview" src="" alt="Aperçu" style="display:none; max-width:300px; border-radius:5px; margin-top:10px;">
                                </div> -->

                                <!-- Link -->
                                <!-- <div class="mb-3">
                    <label class="form-label">
                        Lien (optionnel)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="feather feather-external-link"></i>
                        </span>
                        <input type="url" name="link" class="form-control" placeholder="https://...">
                    </div>
                </div> -->

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="offers.php" class="btn btn-light">
                                        <i class="feather feather-x"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="feather feather-save"></i> Enregistrer
                                    </button>
                                </div>

                            </form>
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
    let descriptionEditor;


    $(document).ready(function() {

        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', 'underline', 'strikethrough',
                        '|', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                    ]
                }
            })
            .then(editor => {
                descriptionEditor = editor;
                editor.ui.view.editable.element.style.minHeight = '400px';
            })
            .catch(error => {
                console.error(error);
            });


        // $('#imageInput').on('change', function() {
        //     const file = this.files[0];
        //     if (file) {
        //         const reader = new FileReader();
        //         reader.onload = function(e) {
        //             $('#imagePreview').attr('src', e.target.result).show();
        //         }
        //         reader.readAsDataURL(file);
        //     } else {
        //         $('#imagePreview').hide();
        //     }
        // });







        $('#offersForm').on('submit', function(e) {
            e.preventDefault();

            const title = $('input[name="title"]').val().trim();
            const description = descriptionEditor.getData().trim();
            const imageFile = $('#documentInput')[0].files[0];

            if (!title) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Titre requis'
                });
                return;
            }

            if (!description) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Description requise'
                });
                return;
            }

            if (!imageFile) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Image requise'
                });
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('document', imageFile);

            $.ajax({
                url: 'assets/php/offers/add_offers.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'appel d\'offres enregistrée !'
                    });

                    $('#offersForm')[0].reset();
                    descriptionEditor.setData('');
                    // $('#documentPreview').hide();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur'
                    });
                }
            });
        });

    });
</script>