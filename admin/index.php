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
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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



                <div class="col-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                          
                            <div class="row">
                                <div class="col-xxl-4 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 bg-primary">
                                        <div class="card-body rounded-3 text-center">
                                            <i class="feather-user text-light" style="font-size: 2rem;"></i>
                                            <div class="fs-4 fw-bolder text-light mt-3 mb-1" id="totalInscription">50,545</div>
                                            <p class="fs-12 fw-medium text-light text-spacing-1 mb-0 text-truncate-1-line">Total d'inscriptions</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 bg-warning">
                                        <div class="card-body rounded-3 text-center">
                                            <i class="feather-clock text-light" style="font-size: 2rem;"></i>
                                            <div class="fs-4 fw-bolder text-light mt-3 mb-1" id="pendingInscription">50,545</div>
                                            <p class="fs-12 fw-medium text-light text-spacing-1 mb-0 text-truncate-1-line">En attente</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 bg-info">
                                        <div class="card-body rounded-3 text-center">
                                            <i class="feather-loader text-light" style="font-size: 2rem;"></i>
                                            <div class="fs-4 fw-bolder text-light mt-3 mb-1" id="progressInscription">25,000</div>
                                            <p class="fs-12 fw-medium text-light text-spacing-1 mb-0 text-truncate-1-line">En cours</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 bg-success">
                                        <div class="card-body rounded-3 text-center">
                                            <i class="feather-check-circle text-light" style="font-size: 2rem;"></i>
                                            <div class="fs-4 fw-bolder text-light mt-3 mb-1" id="validInscription">20,354</div>
                                            <p class="fs-12 fw-medium text-light text-spacing-1 mb-0 text-truncate-1-line">Validés</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-lg-4 col-md-6">
                                    <div class="card stretch stretch-full border border-dashed border-gray-5 bg-danger">
                                        <div class="card-body rounded-3 text-center">
                                            <i class="feather-x-circle text-light" style="font-size: 2rem;"></i>
                                            <div class="fs-4 fw-bolder text-light mt-3 mb-1" id="refusedInscription">20,354</div>
                                            <p class="fs-12 fw-medium text-light text-spacing-1 mb-0 text-truncate-1-line">Réfusés</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Nombre d'inscription par mois</h5>
                            <div class="card-header-action">
                              
                            </div>
                        </div>
                        <div class="card-body custom-card-action">
                            <div id="websitean-alytics-bar-chart"></div>
                        </div>
                    </div>
                </div>


                <!--! END: [Team Progress] !-->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>

</main>


<?php
include('includes/footer.php');
?>
<!-- <script src="assets/js/widgets-charts-init.min.js"></script> -->



<script>
var chart;

$(document).ready(function(){

    $.ajax({
        url: 'assets/php/dashboard/dashboard_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data){

            if(data.error){
                console.log(data.error);
                return;
            }

            // =========================
            // CARDS
            // =========================
            $('#totalInscription').text(data.total);
            $('#pendingInscription').text(data.pending);
            $('#progressInscription').text(data.progress);
            $('#validInscription').text(data.valid);
            $('#refusedInscription').text(data.refused);

            // =========================
            // CHART (same design, backend data)
            // =========================
            chart = new ApexCharts(document.querySelector("#websitean-alytics-bar-chart"), {
                chart: {
                    type: "bar",
                    height: 425,
                    toolbar: { show: false }
                },
                series: [
                    {
                        name: "Inscriptions",
                        data: data.months   // DATA FROM PHP
                    },
                ],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: "rounded",
                        columnWidth: "25%"
                    },
                },
                dataLabels: {
                    enabled: false,
                    offsetX: -6,
                    style: {
                        fontSize: "12px",
                        colors: ["#fff"]
                    },
                },
                stroke: {
                    show: false,
                    width: 1,
                    colors: ["#fff"]
                },
                colors: ["#3454d1"],
                xaxis: {
                    categories: [
                        "Jan","Feb","Mar","Apr","May","Jun",
                        "Jul","Aug","Sep","Oct","Nov","Dec"
                    ],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: "#64748b",
                            fontFamily: "Inter"
                        }
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(e) {
                            return e; // remove "K" if real DB numbers
                        },
                        offsetX: -22,
                        offsetY: 0,
                        style: {
                            color: "#64748b",
                            fontFamily: "Inter"
                        },
                    },
                },
                grid: {
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 30,
                        left: 0
                    },
                    strokeDashArray: 3,
                    borderColor: "#e9ecef",
                },
                tooltip: {
                    y: {
                        formatter: function(e) {
                            return e;
                        },
                    },
                    style: {
                        colors: "#64748b",
                        fontFamily: "Inter"
                    },
                },
                legend: {
                    show: true,
                    labels: {
                        colors: "#64748b"
                    },
                    fontFamily: "Inter"
                },
            });

            chart.render();
        },
        error: function(xhr){
            console.log("AJAX Error:", xhr.responseText);
        }
    });

});
</script>