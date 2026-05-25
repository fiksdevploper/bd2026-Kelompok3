<?php
session_start();

// 1. Proteksi Halaman: Pastikan user sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

// 2. Panggil Koneksi Database
require_once '../koneksi.php';

// 3. Cek apakah ada parameter NIM yang dikirim lewat URL
if (isset($_GET['nim'])) {
    $nim = mysqli_real_escape_string($link, $_GET['nim']);

    // 4. Jalankan Query Delete
    $query = "DELETE FROM tbl_mhs WHERE nim = '$nim'";
    $exec = mysqli_query($link, $query);

    // 5. Berikan feedback menggunakan SweetAlert2 sebelum redirect
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Memproses Hapus Data...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <style>body { font-family: 'Poppins', sans-serif; }</style>
    </head>
    <body>
        <script>
            <?php if ($exec): ?>
                Swal.fire({
                    title: 'Berhasil Dihapus!',
                    text: 'Data mahasiswa dengan NIM <?php echo $nim; ?> telah dihapus.',
                    icon: 'success',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Oke'
                }).then(() => {
                    window.location.href = 'mahasiswa.php';
                });
            <?php else: ?>
                Swal.fire({
                    title: 'Gagal Menghapus!',
                    text: 'Terjadi kesalahan sistem: <?php echo mysqli_error($link); ?>',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Kembali'
                }).then(() => {
                    window.location.href = 'mahasiswa.php';
                });
            <?php endif; ?>
        </script>
    </body>
    </html>
    <?php
} else {
    // Jika tidak ada parameter NIM di URL, langsung balikkan ke halaman utama
    header("Location: mahasiswa.php");
    exit;
}
?>