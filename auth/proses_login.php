<?php
session_start();
require_once dirname(__DIR__) . '/koneksi.php';

// Sertakan CDN SweetAlert2 dan Google Fonts agar tampilannya konsisten sebelum eksekusi script
echo '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: "Poppins", sans-serif; }
</style>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['login']    = true;
            $_SESSION['username'] = $row['username'];

            // SWEETALERT: Berhasil Masuk
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Log In Berhasil!',
                        text: 'Selamat datang kembali, " . $row['username'] . " 👋',
                        icon: 'success',
                        confirmButtonColor: '#007bff',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '../index.php';
                    });
                });
            </script>";
            exit;
        }
    }

    // SWEETALERT: Gagal Login (Salah Password / Username)
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Log In Gagal!',
                text: 'Username atau Password Admin Salah, silakan periksa kembali.',
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Coba Lagi'
            }).then(() => {
                window.location.href = 'login.php';
            });
        });
    </script>";
    exit;
}
?>