<?php include 'includes/header.php'; ?>
<style>
    .bg-breadcrumb {
        position: relative;
        overflow: hidden;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(./img/offres02.png);
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 60px 0 60px 0;
    }

    body {
        background-color: #f4f6f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .offer-card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .offer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .offer-card .card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .offer-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: #102147;
    }

    .offer-description {
        flex-grow: 1;
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 1rem;
    }

    .offer-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #888;
    }

    .download-btn {
        background: #102147;
        border: none;
        color: #fff;
        padding: 0.45rem 0.8rem;
        font-size: 0.9rem;
        border-radius: 8px;
        text-decoration: none;
        transition: background 0.3s;
    }
</style>
<!-- Header Start -->
<div class="container-fluid bg-breadcrumb">
    <div class="bg-breadcrumb-single"></div>
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Appels d'offres</h4>
        <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>

            <li class="breadcrumb-item active text-primary">Appels d'offres</li>
        </ol>
    </div>
</div>
<!-- Header End -->

<!-- Services Start -->
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary">Appels d'offres</h4>
            <!-- <h1 class="display-4"> Offering the Best Consulting & Investa Services</h1> -->
        </div>

        <div class="row g-4">

            <!-- Card 1 -->
            <div class="col-md-6">
                <div class="offer-card position-relative h-100">
                    <div class="card-body d-flex flex-column">
                        <!-- <span class="badge-new">Nouveau</span> -->
                        <h5 class="offer-title">Construction Résidence Scolaria</h5>
                        <p class="offer-description">Projet de construction de 54 logements dans la wilaya d'Alger.</p>
                        <div class="offer-footer mt-auto">
                            <span>Publié le: 2026-02-09</span>
                            <a href="documents/residence_scolaria.pdf" class="download-btn" download>Télécharger</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6">
                <div class="offer-card position-relative h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="offer-title">Promotion 30 logements Oran</h5>
                        <p class="offer-description">Appel d'offre pour 30 logements promotionnels dans la wilaya d'Oran.</p>
                        <div class="offer-footer mt-auto">
                            <span>Publié le: 2026-01-25</span>
                            <a href="documents/oran_30_logements.pdf" class="download-btn" download>Télécharger</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6">
                <div class="offer-card position-relative h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="offer-title">Local commercial Blida</h5>
                        <p class="offer-description">Appel d'offre pour 19 logements avec commerces à Blida.</p>
                        <div class="offer-footer mt-auto">
                            <span>Publié le: 2026-01-10</span>
                            <a href="documents/blida_local_commercial.pdf" class="download-btn" download>Télécharger</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- Services End -->


<?php include 'includes/footer.php'; ?>