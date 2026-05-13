<?php
session_start();
include '../config/koneksi.php';

// Jika sudah login, langsung tendang ke dashboard
if(isset($_SESSION['login'])) { header("Location: dashboard.php"); exit; }

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $q = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if(mysqli_num_rows($q) > 0){
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - RentalMobil</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .btn-modern {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px;
        }
        .input-group-text {
            background-color: white;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        /* Efek fokus pada input group */
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-radius: 0.375rem;
        }
    </style>
</head>
<body>

<div class="card login-card p-4">
    <div class="card-body text-center">
        <!-- Logo / Icon -->
        <div class="mb-4">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
                <i class="bi bi-person-lock fs-1"></i>
            </div>
            <h3 class="fw-bold text-dark mt-3 mb-1">Login Admin</h3>
            <p class="text-muted small">Masuk untuk mengelola sistem rental</p>
        </div>

        <!-- Alert Error -->
        <?php if(isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show text-start small rounded-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form method="POST" action="">
            <div class="mb-3 text-start">
                <label class="form-label fw-medium small text-secondary">Username</label>
                <div class="input-group shadow-sm rounded-3">
                    <span class="input-group-text text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>
            </div>
            
            <div class="mb-4 text-start">
                <label class="form-label fw-medium small text-secondary">Password</label>
                <div class="input-group shadow-sm rounded-3">
                    <span class="input-group-text text-muted"><i class="bi bi-key"></i></span>
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Masukkan password" required>
                    <!-- Tombol Toggle Show/Hide Password -->
                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword" style="background-color: white; border-color: #dee2e6;">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-modern shadow-sm fs-5 mb-4">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </button>
            
            <!-- Tombol Navigasi -->
            <a href="../pages/home.php" class="text-decoration-none text-muted small link-primary"><i class="bi bi-arrow-left"></i> Kembali ke Beranda User</a>
        </form>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Tampilkan/Sembunyikan Password -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#inputPassword');
    const toggleIcon = document.querySelector('#toggleIcon');

    togglePassword.addEventListener('click', function () {
        // Toggle atribut type antara password dan text
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle ikon mata
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>