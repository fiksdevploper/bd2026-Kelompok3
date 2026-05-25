<?php
session_start();

// Jika tidak ada session login atau nilainya bukan true, kunci halamannya
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Poppins", sans-serif; }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Akses Ditolak!',
                text: 'Anda tidak memiliki izin. Silakan login terlebih dahulu untuk masuk ke sistem.',
                icon: 'warning',
                confirmButtonColor: '#e67e22',
                confirmButtonText: 'Menuju Halaman Login',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = 'auth/login.php';
            });
        });
    </script>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Fakultas Ilmu Komputer</title>
    
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <header class="header-site">
        <img src="images/logo.png" alt="Logo BEM FILKOM" class="navbar-logo">

        <div class="header-content">
            <?php include "layouts/atas.php"; ?>
        </div>
    </header>

    <div class="main-container">

        <aside class="sidebar-site">
            <?php include "layouts/menu_kiri.php"; ?>
        </aside>

        <main class="content-site">
            <h1>Selamat datang admin</h1>
        </main>
    </div>

    <footer class="footer-site">
        <?php include "layouts/bawah.php"; ?>
    </footer>
</body>
</html>