<?php
session_start();
// Mundur satu folder untuk mengambil koneksi.php
require_once '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // PERBAIKAN: Mengubah $koneksi menjadi $link
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];

    // PERBAIKAN: Mengubah $koneksi menjadi $link, dan target tabel ke 'admin'
    $query  = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password Bcrypt
        if (password_verify($password, $row['password'])) {
            $_SESSION['login']    = true;
            $_SESSION['username'] = $row['username'];

            // Sukses login: diarahkan ke halaman utama di folder luar
            header("Location: ../index.php"); 
            exit;
        }
    }

    // Jika gagal, tampilkan alert dan kembalikan ke login.php
    echo "<script>
            alert('Username atau Password Admin Salah!');
            window.location.href = 'login.php';
        </script>";
}
?>