<?php

include('includes/header.php');
?>


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
                                        <tr class="single-item">
                                            <td>
                                                <div class="item-checkbox ms-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox" id="checkBox_1">
                                                        <label class="custom-control-label" for="checkBox_1"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="javascript:void(0);" class="fw-bold">#321456</a></td>
                                            <td>
                                                <a href="javascript:void(0)" class="hstack gap-3">
                                                    <div class="avatar-image avatar-md">
                                                        <img src="assets/images/avatar/1.png" alt="" class="img-fluid">
                                                    </div>
                                                    <div>
                                                        <span class="text-truncate-1-line">Alexandra Della</span>
                                                        <small class="fs-12 fw-normal text-muted">alex@example.com</small>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>A business proposal for a new product or service</td>
                                            <td class="fw-bold text-dark">$249.99 USD</td>
                                            <td>2023-04-25, 03:42PM</td>
                                            <td>
                                                <div class="badge bg-soft-success text-success">Sent</div>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>









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
    "use strict";
    $(document).ready(function() {
        $(".progress-1").circleProgress({
            max: 100,
            value: 50,
            textFormat: function() {
                return "$450 USD"
            }
        }), $(".progress-2").circleProgress({
            max: 100,
            value: 60,
            textFormat: function() {
                return "$550 USD"
            }
        }), $(".progress-3").circleProgress({
            max: 100,
            value: 70,
            textFormat: function() {
                return "$850 USD"
            }
        }), $(".progress-4").circleProgress({
            max: 100,
            value: 80,
            textFormat: function() {
                return "$900 USD"
            }
        })
    }), $(document).ready(function() {
        $("#proposalList").DataTable({
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100, 200, 500]
        })
    }), $(document).ready(function() {
        $("#checkAllProposal").change(function() {
            this.checked ? $(".checkbox").each(function() {
                this.checked = !0, $(this).parent().parent().parent().parent().addClass("selected")
            }) : $(".checkbox").each(function() {
                this.checked = !1, $(this).parent().parent().parent().parent().removeClass("selected")
            })
        }), $(".checkbox").click(function() {
            var e;
            $(this).is(":checked") ? (e = 0, $(".checkbox").each(function() {
                this.checked || (e = 1)
            }), 0 == e && $("#checkAllProposal").prop("checked", !0)) : $("#checkAllProposal").prop("checked", !1)
        }), $(".items-wrapper").on("click", "input:checkbox", function() {
            $(this).closest(".single-items").toggleClass("selected", this.checked)
        }), $(".items-wrapper input:checkbox:checked").closest(".single-items").addClass("selected")
    }), $(document).ready(function() {
        new Quill('[data-editor-target="editor"]', {
            placeholder: "Compose an epic...",
            theme: "snow"
        })
    }), $(document).ready(function() {
        $('[data-alert-target="alertMessage"]').click(function(e) {
            e.preventDefault();
            const t = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-1",
                    cancelButton: "btn btn-danger m-1"
                },
                buttonsStyling: !1
            });
            t.fire({
                title: "Are you sure?",
                text: "You want to sent this Proposal!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, sent it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(e => {
                e.value ? t.fire("Sent!", "Proposal sent successfully.", "success") : e.dismiss === Swal.DismissReason.cancel && t.fire("Cancelled", "Your imaginary file is safe :)", "error")
            })
        })
    });
</script>