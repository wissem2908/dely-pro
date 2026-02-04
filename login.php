<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    html,
    body {
        height: 100%;
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: url("assets/images/bg04.png") no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    body::before {
        content: "";
        position: fixed;
        /* fixed so it stays behind content */
        inset: 0;
        /* top:0; right:0; bottom:0; left:0; */
        background-color: #102147;
        opacity: 0.6;
        /* adjust transparency (0.0–1.0) */
        z-index: 0;
        /* behind all content */
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    }

    .login-card h4 {
        text-align: center;
        font-weight: 600;
        margin-bottom: 25px;
        color: #1f2937;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #d1d5db;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 .15rem rgba(37, 99, 235, .15);
    }

    .btn-login {
        background: #102147;
        border: none;
        padding: 12px;
        border-radius: 10px;
        font-weight: 500;
    }

    .btn-login:hover {
        background: #1e40af;
    }

    .login-footer {
        text-align: center;
        margin-top: 18px;
        font-size: 13px;
        color: #6b7280;
    }
</style>

<div class="login-container">
    <div class="login-card">

        <div class="mb-3">
            <img src="assets/images/delypro-logo.png" alt="Logo" width="200" height="auto" class="mx-auto d-block">
        </div>
        <h4>Connexion</h4>
        <form id="loginForm">
            <div class="mb-3">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- Inscription link -->
            <div class="text-center mb-3">
                <span class="text-muted">Vous n’avez pas de compte ?</span>
                <a href="client.php" class="text-decoration-none fw-medium text-primary">
                    S’inscrire
                </a>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login text-white">
                    Se connecter
                </button>
            </div>
        </form>


    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.all.min.js"></script>

<?php include 'includes/footer.php'; ?>


<script>


$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'assets/php/login.php',
            data: $(this).serialize(),
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Connexion réussie',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        if(res.role === 'admin')
                                 window.location.href = './admin';
                        else   {
                                 window.location.href = './admin/demandes.php';
                        }
                   
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur de connexion',
                        text: res.message
                    });
                }
            }
        });
    });
});

</script>